<?php
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 08/11/17
 * Time: 16:12
 */

namespace AppBundle\Utils;


use GuzzleHttp\Client;

/**
 * Class for connected site to a distant api with specific function and parameters
 *
 * Class apiConnect
 * @package AppBundle\Utils
 *
 */
class apiConnect {

    private $url;
    private $privateKey;
    private $publicKey;

    /**
     * apiConnect constructor.
     *
     * @param string $url
     * @param string $privateKey
     * @param string $publicKey
     */
    public function __construct(string $url, string $privateKey, string $publicKey)
    {
        $this->url = $url;
        $this->privateKey = $privateKey;
        $this->publicKey = $publicKey;
    }

    /**
     * Function which initialise a new client
     * with specific parameters and queries
     * and return a Json with some informations
     *
     * @param int $limit
     * @param int $offset
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function connection(int $limit, int $offset, string $orderBy)
    {

        $client = new Client();
        $timeStamp = time();
        $hash = $this->hash( $this->privateKey,$this->publicKey);

        $response = $client->request('GET', $this->url,
            [
                'base_uri' => $this->url,
                'query' =>
                    [
                        'limit' => $limit,
                        'offset' => $offset,
                        'orderBy' => $orderBy,
                        'ts' => $timeStamp,
                        'apikey' => $this->publicKey,
                        'hash' => $hash
                    ]
            ]);

        return $response->getBody() ;
    }

    /**
     * Function allow to return a mandatory hash to connected to the api
     * @param string $privateKey
     * @param string $publicKey
     *
     * @return string
     */
    public function hash(string $privateKey, string $publicKey):string
    {
        $timeStamp = time();

        $hash = md5($timeStamp.$privateKey.$publicKey);

        return $hash;
    }
}