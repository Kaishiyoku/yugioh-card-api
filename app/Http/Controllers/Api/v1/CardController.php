<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessCardImage;
use App\Models\LinkMonsterCard;
use App\Models\MonsterCard;
use App\Models\PendulumMonsterCard;
use App\Models\RitualMonsterCard;
use App\Models\Set;
use App\Models\Setable;
use App\Models\SpellCard;
use App\Models\SynchroMonsterCard;
use App\Models\TrapCard;
use App\Models\XyzMonsterCard;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class CardController extends Controller
{
    public function index()
    {
        $withMapperAndOperations = function ($cardClass) {
            return $this->withCardSetMapper($this->withDefaultCardOperations($cardClass, true));
        };

        return CardController::getCardsResponse($withMapperAndOperations, true);
    }

    public function search($title)
    {
        $withMapperAndOperations = function ($title) {
            return function ($cardClass) use ($title) {
                return $this->withCardSetMapper($this->withDefaultSearchOperations($cardClass, $title)->get());
            };
        };

        return CardController::getCardsResponse($withMapperAndOperations($title));
    }

    public function getCardFromSet($identifier)
    {
        if (!Str::contains($identifier, '-')) {
            return response()->json(new \stdClass());
        }

        list($setIdentifier, $cardIdentifier) = explode('-', $identifier);

        $set = Set::whereIdentifier($setIdentifier)->first();

        $cardSet = Setable::whereIdentifier($cardIdentifier)
            ->whereSetId($set->id)
            ->first();

        if (empty($cardSet)) {
            return response()->json(new \stdClass());
        }

        $card = $cardSet->setable_type::where('id', $cardSet->setable_id)->first();

        return response()->json([
            'set' => $set,
            'card_set' => $cardSet,
            'card' => $card,
        ]);
    }

    public function getImage($identifier)
    {
        if (!Str::contains($identifier, '-')) {
            return response()->json(new \stdClass());
        }

        list($setIdentifier, $cardIdentifier) = explode('-', $identifier);

        $set = Set::whereIdentifier($setIdentifier)->first();

        if (empty($set)) {
            return response()->json(new \stdClass());
        }

        $cardSet = Setable::whereIdentifier($cardIdentifier)
            ->whereSetId($set->id)
            ->first();

        if (empty($cardSet)) {
            return response()->json(new \stdClass());
        }

        $card = $cardSet->setable_type::where('id', $cardSet->setable_id)->first();

        $filePath = '/card_images/' . ProcessCardImage::getCardType($card) . '/' . Str::slug($card->title_english) . '.png';

        $imageContent = Storage::disk('local')->exists($filePath) ? Storage::disk('local')->get($filePath) : Storage::disk('local')->get('/card_images/default.png');

        return Image::make($imageContent)->response('png', 100);
    }

    private function withDefaultCardOperations($cardClass, $withPagination = false)
    {
        $model = $cardClass::orderBy('title_german')
            ->orderBy('title_english');

        if ($withPagination) {
            $model = $model->paginate(env('CARDS_PER_PAGE'));
        }

        return $model;
    }

    private function withCardSetMapper($card)
    {
        return $card->map(function ($card) {
            return [
                'card' => $card,
                'card_sets' => Setable::whereSetableId($card->id)->whereSetableType(get_class($card))->get()->map(function ($setable) {
                    $set = Set::find($setable->set_id);

                    $setable->identifier = $set->identifier . '-' . $setable->identifier;

                    return $setable;
                }),
            ];
        });
    }

    private function withDefaultSearchOperations($cardClass, $title)
    {
        return $cardClass::where('title_german', 'LIKE', '%' . $title . '%')
            ->orWhere('title_english', 'LIKE', '%' . $title . '%');
    }

    private static function getCardsResponse($operatorFn, $withPagination = false)
    {
        $perPage = env('CARDS_PER_PAGE');
        $cardClasses = collect([
            MonsterCard::class,
            RitualMonsterCard::class,
            LinkMonsterCard::class,
            SynchroMonsterCard::class,
            XyzMonsterCard::class,
            PendulumMonsterCard::class,
            SpellCard::class,
            TrapCard::class,
        ]);

        $cardResults = $cardClasses->mapWithKeys(function ($cardClass) use ($operatorFn) {
            $cardName = Str::snake(Str::plural(array_last(explode("\\", $cardClass))));

            return [$cardName => $operatorFn($cardClass)];
        });

        $additionalValues = [];

        $lastPage = $cardClasses->reduce(function ($carry, $cardClass) use ($perPage) {
            $lastPage = $cardClass::paginate($perPage)->lastPage();

            return $lastPage > $carry ? $lastPage : $carry;
        }, 1);

        if ($withPagination) {
            $additionalValues = [
                'info' => [
                    'last_page' => $lastPage,
                ],
            ];
        }

        return response()->json(array_merge($additionalValues, $cardResults->toArray()));
    }
}
