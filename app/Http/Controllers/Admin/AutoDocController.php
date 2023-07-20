<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Openapi\Attributes\Server;
use App\Openapi\Exceptions\AttributeException;
use App\Openapi\Exceptions\ParseException;
use App\Openapi\OpenApiParser;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use ReflectionException;

class AutoDocController extends Controller
{
    /**
     * Страница документации
     *
     * @return Factory|View|Application
     */
    public function autodoc(): Factory|View|Application
    {
        return view('admin.autodoc');
    }

    /**
     * Генерирует и возвращает спецификацию в JSON формате
     *
     * @return Response|JsonResponse|Application|ResponseFactory
     */
    public function specification(): Response|JsonResponse|Application|ResponseFactory
    {
        $parser = new OpenApiParser(__DIR__ . '/../../../../vendor/autoload.php');

        try {
            $spec = $parser->build(['App'])
                ->addServer(new Server(env('API_URL'), 'АПИ хост соответствующий админке'))
                ->toJson();
        } catch (AttributeException | ReflectionException | ParseException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'trace'   => $e->getTrace(),
            ], 500);
        }

        return response($spec);
    }
}
