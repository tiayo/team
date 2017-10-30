<?php

namespace App;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class GetController
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * 获取文章
     *
     * @return string
     */
    public function get()
    {
        //读取token
        $token = file_get_contents(dirname(__DIR__).'/.token');

        //未获取到token则请求token
        if (empty($token)) {
            $token = $this->token()->access_token;
        }

        try {
            $response = $this->client->request('GET', config('site').'/api/get_article', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer '.$token,
                ],
                'query' => [
                    'num' => config('num'),
                    'category_id' => config('category_id'),
                ],
            ]);
        } catch (RequestException $exception) {
            $this->token();
            return null;
        }

        return $response->getBody()->getContents() ?? null;
    }

    /**
     * 获取token并保存
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function token()
    {
        $response = $this->client->post(config('site').'/oauth/token', [
            'form_params' => [
                'grant_type' => config('grant_type'),
                'client_id' => config('client_id'),
                'client_secret' => config('client_secret'),
                'username' => config('username'),
                'password' => config('password'),
                'scope' => config('scope'),
            ],
        ]);

        $response = json_decode($response->getBody()->getContents());

        //写入文件
        $open = fopen(dirname(__DIR__).'/.token', 'w');
        fwrite($open, $response->access_token);
        fclose($open);

        return $response;
    }
}