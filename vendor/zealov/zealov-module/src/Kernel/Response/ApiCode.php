<?php


namespace Zealov\Kernel\Response;


use Kayex\HttpCodes;

class ApiCode extends HttpCodes
{
    const HTTP_UNPROCESSABLE_ENTITY = 422;
    const HTTP_TOO_MANY_REQUEST = 429;
    const HTTP_TOKEN_EXPIRED = 430;
}
