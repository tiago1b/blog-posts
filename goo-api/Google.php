<?php
/**
 * Google URL Shortener API
 *
 * Classe básica para utilização da Google URL Shortener API
 *
 * @author     Felipe Rodrigues <felipe@felipedjinn.com.br>
 * @version    0.1
 * @link       https://github.com/felipedjinn/blog-posts/tree/master/goo-api
 */
class Google
{
    /**
     * Chave para utilização da API
     *
     * @var string
     */
    const GOOGLE_API_KEY = 'AIzaSyC8Nojxz1DOb73N_ELikppQR0T8vcuC78U';

    /**
     * URL de acesso a API
     *
     * @var string
     */
    const GOOGLE_API_ENDPOINT = 'https://www.googleapis.com/urlshortener/v1';

    /**
     * Encurta uma url através da Google URL Shortener API
     *
     * Retorna uma stdClass contendo os dados retornados pela API.
     * Exemplo:
     * <code>
     * stdClass Object
     * (
     *     [kind] => urlshortener#url
     *     [id] => http://goo.gl/ycdKd
     *     [longUrl] => http://felipedjinn.com.br/
     * )
     * </code>
     *
     * @static
     * @param  string $url
     * @return stdClass
     */
    static public function shortenUrl($url)
    {
        // inicia a conexão cURL
        $ch = curl_init(sprintf(
            '%s/url?key=%s', self::GOOGLE_API_ENDPOINT, self::GOOGLE_API_KEY
        ));

        // diz ao cURL para retornar os dados ao invés de enviar diretamente para a saida
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // faz a requisição via POST
        curl_setopt($ch, CURLOPT_POST, true);

        // seta o content type para application/json
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));

        // seta os dados para enviar na requisição
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array('longUrl' => $url)));

        // executa a requisição
        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result);
    }
}
