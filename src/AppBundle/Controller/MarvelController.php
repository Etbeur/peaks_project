<?php
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 04/11/17
 * Time: 17:56
 */

namespace AppBundle\Controller;

use AppBundle\Utils\apiConnect;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class MarvelController extends Controller
{
    /**
     * Principal routes where you can see characters between numbers 100 and 122
     * @Route("/marvel", name="marvelHome")
     *
     */
    public function connectAction()
    {
        $newClient = new apiConnect(
            'https://gateway.marvel.com/v1/public/characters',
            'Your privateKey',
            'Your publicKey'
        );

        $data = $newClient->connection( 20, 100, 'name' );

        return $this->render('index.html.twig', [
            'resultats' => json_decode( $data )->data->results
        ]);
    }

    /**
     * Specific Route to see details of one character
     * @Route("/marvel/{id}", name="marvel_perso")
     *
     */

    public function fichePersoAction(int $id)
    {
        $newClient = new apiConnect(
            'https://gateway.marvel.com/v1/public/characters/'.$id,
            'Your privateKey',
            'Your publicKey'
        );

        $data = $newClient->connection( 20, 100, 'name' );

        return $this->render('perso.html.twig', [
            'persos' => json_decode($data)->data->results
        ]);
    }

}