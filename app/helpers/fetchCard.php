<?php

if (!function_exists('fetchCard')) {
    /**
     * @param $attribute
     * @param $cardUrl
     * @param null $logger
     * @param $lang
     * @return \Illuminate\Database\Eloquent\Model
     */
    function fetchCard($attribute, $cardInfo, $cardUrl, $logger = null, $lang = 'en')
    {
        if ($logger) {
            $logger->info('  crawling card: ' . $cardUrl);
        }

        $availableAttributes = [
            'de' => [
                'monster' => 'MONSTER',
                'spell' => 'ZAUBER',
                'trap' => 'FALLE',
            ],
            'en' => [
                'monster' => 'MONSTER',
                'spell' => 'SPELL',
                'trap' => 'TRAP',
            ],
        ];

        $attributes = $availableAttributes[$lang];

        if ($attribute == $attributes['spell']) {
            return fetchSpell($cardUrl);
        } else if ($attribute == $attributes['trap']) {
            return fetchTrap($cardUrl);
        } else {
            if (\Illuminate\Support\Str::contains($cardInfo, 'Pendulum')) {
                return fetchPendulumMonster($cardUrl);
            }

            if (\Illuminate\Support\Str::contains($cardInfo, 'Link')) {
                return fetchLinkMonster($cardUrl);
            }

            if (\Illuminate\Support\Str::contains($cardInfo, 'Xyz')) {
                return fetchXyzMonster($cardUrl);
            }

            if (\Illuminate\Support\Str::contains($cardInfo, 'Synchro')) {
                return fetchSynchroMonster($cardUrl);
            }

            if (\Illuminate\Support\Str::contains($cardInfo, 'Ritual')) {
                return fetchRitualMonster($cardUrl);
            }

            return fetchMonster($cardUrl);
        }
    }
}
