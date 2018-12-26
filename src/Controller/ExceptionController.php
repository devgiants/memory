<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 05/11/18
 * Time: 17:58
 */

namespace App\Controller;
use FOS\RestBundle\Util\ExceptionValueMap;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Log\DebugLoggerInterface;
/**
 * Custom ExceptionController that renders to json
 *
 * Configure it like so:
app.json_exception_controller:
public: true
class: App\Controller\ExceptionController
arguments:
- '@fos_rest.exception.codes_map'
 */
class ExceptionController
{
	/**
	 * @var ExceptionValueMap
	 */
	private $exceptionCodes;

	public function __construct(ExceptionValueMap $exceptionCodes) {
		$this->exceptionCodes = $exceptionCodes;
	}
	/**
	 * Converts an Exception to a Response.
	 *
	 * @param Request                   $request
	 * @param \Exception|\Throwable     $exception
	 * @param DebugLoggerInterface|null $logger
	 *
	 * @throws \InvalidArgumentException
	 *
	 * @return Response
	 */
	public function showAction(Request $request, $exception, DebugLoggerInterface $logger = null)
	{
		$code = $this->getStatusCode($exception);
		return new Response(
			json_encode(
				['error' => $exception->getMessage()],
				JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
			),
			$code,
			['Content-type' => 'application/json']
		);
	}
	/**
	 * Determines the status code to use for the response.
	 *
	 * @param \Exception $exception
	 *
	 * @return int
	 */
	protected function getStatusCode(\Exception $exception)
	{
		// If matched
		if ($statusCode = $this->exceptionCodes->resolveException($exception)) {
			return $statusCode;
		}
		// Otherwise, default
		if ($exception instanceof HttpExceptionInterface) {
			return $exception->getStatusCode();
		}
		return 500;
	}
}