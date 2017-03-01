<?php

namespace AppBundle\Service;

use GuzzleHttp\Client;

class GitHubApi
{
    /** @var  Client */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }
    public function getProfile($username)
    {
        $response = $this->client->request('GET', 'https://api.github.com/users/'.$username);

        $data = json_decode($response->getBody()->getContents(), true);
        dump($data);
        $vars = [
            'login' => $data['login'],
            'name' => $data['name'],
            'avatar' => $data['avatar_url'],
            'company' => $data['company'],
            'location' => $data['location'],
            'email' => $data['email'],
            'blog' => $data['blog'],
            'bio' => $data['bio'],
            'data' => [
                [
                    'name' => 'Repositories',
                    'value' => $data['public_repos'],
                    'url' => 'https://github.com/'.$data['login'].'/repositories'
                ],
                [
                    'name' => 'Followers',
                    'value' => $data['followers'],
                    'url' => 'https://github.com/'.$data['login'].'/followers'
                ],
                [
                    'name' => 'Following',
                    'value' => $data['following'],
                    'url' => 'https://github.com/'.$data['login'].'/following'
                ]
            ]
        ];

        return $vars;
    }

    public function getRepositories($username)
    {
        $response = $this->client->request('GET', 'https://api.github.com/users/'.$username.'/repos');

        return json_decode($response->getBody()->getContents(), true);
    }
}