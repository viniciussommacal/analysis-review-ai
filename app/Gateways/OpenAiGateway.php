<?php

namespace App\Gateways;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OpenAiGateway
{
    private function buildAssistantPrompt(): string
    {
        return "
            Você é um analista de comentários de uma plataforma de produtos online.
            Seu papel é analisar o comentário abaixo sobre o produto e classificá-lo de 1 a 5:

            1 - PÉSSIMO
            2 - RUIM
            3 - NEUTRO
            4 - BOM
            5 - EXCELENTE

            #Regras
            - Caso não haja contexto suficiente para classificar, considere '3'
            - Não considere política na análise

            #Resposta (IMPORTANTE)
            Sua resposta deve ser apenas o número correspondente à classificação.
            Ex.: 5
        ";
    }

    public function processComment(object $review): int
    {
        $apiKey = env('OPENAI_API_KEY');

        if (!$apiKey) {
            throw new Exception('OpenAI API key not configured.');
        }

        $comment = "
            #Produto
            {$review->product_name}

            #Comentário do consumidor
            {$review->comment}
        ";

        $assistantPrompt = $this->buildAssistantPrompt();

        $url = 'https://api.openai.com/v1/chat/completions';
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
            'Content-Type' => 'application/json',
        ])->post($url, [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => $assistantPrompt
                ],
                [
                    'role' => 'user',
                    'content' => $comment
                ],
            ],
            'temperature' => 0,
        ]);

        Log::info(json_encode($response->json(), JSON_PRETTY_PRINT));

        if (!$response->successful()) {
            throw new Exception("Analyse Comment: OpenAI API request failed with status {$response->status()}");
        }

        $data = $response->json();

        if (isset($data['choices'][0]['message']['content'])) {
            $content = trim($data['choices'][0]['message']['content']);

            if (preg_match('/[1-5]/', $content, $matches)) {
                return (int) $matches[0];
            }

            throw new Exception("Analyse Comment: Invalid rating returned by OpenAI: '{$content}'");
        }

        throw new Exception("Analyse Comment: Unexpected response structure from OpenAI.");
    }
}
