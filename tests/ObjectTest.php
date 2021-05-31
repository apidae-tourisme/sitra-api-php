<?php

namespace Sitra\Tests;

class ObjectTest extends Base
{
    public function test()
    {
        $client = $this->getClient(0);

        /**
         * @see https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services
         * v002/objet-touristique/get-by-id/
         */
        $client->getObjectById(['id' => 760958]);
        $this->assertEquals("/api/v002/objet-touristique/get-by-id/760958", $this->lastPath());

        $client->getObjectById(['id' => 760958, 'responseFields' => '@all', 'locales' => 'fr,en']);
        $this->assertEquals([
            'projetId' => $this->options['projetId'],
            'apiKey' => $this->options['apiKey'],
            'responseFields' => '@all',
            'locales' => 'fr,en'
        ], $this->lastQuery());

        $client->getObjectById(['id' => 760958, 'responseFields' => 'informations.moyensCommunication,localisation']);
        $this->assertEquals([
            'projetId' => $this->options['projetId'],
            'apiKey' => $this->options['apiKey'],
            'responseFields' => 'informations.moyensCommunication,localisation'
        ], $this->lastQuery());

        /**
         * @see https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services
         * v002/objet-touristique/get-by-idendifier/
         */
        $client->getObjectByIdentifier(['identifier' => 'SITRA2_STR_760958']);
        $this->assertEquals("/api/v002/objet-touristique/get-by-identifier/SITRA2_STR_760958", $this->lastPath());
        $this->assertEquals([
            'projetId' => $this->options['projetId'],
            'apiKey' => $this->options['apiKey']
        ], $this->lastQuery());
    }
}
