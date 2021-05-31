<?php

namespace Sitra\Tests;

class SearchTest extends Base
{
    public function test()
    {
        $client = $this->getClient(0);

        /**
         * @see https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/liste-des-services
         * v002/recherche/list-identifiants/
         */

        /**
         * @see https://dev.apidae-tourisme.com/fr/documentation-technique/v2/api-de-diffusion/format-des-recherches
         */
        $query = ['selectionIds' => [109426]];
        $result = $client->searchObjectIdentifier(['query' => $query]);
        var_dump($result);

        $this->assertEquals("/api/v002/recherche/list-identifiants", $this->lastPath());

        $this->assertEquals([
            'query' => [
                'projetId' => $this->options['projetId'],
                'apiKey' => $this->options['apiKey'],
                'selectionIds' => 109426
            ]
        ], $this->lastQuery());
    }
}
