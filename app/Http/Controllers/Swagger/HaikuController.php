<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;
use App\Http\Requests\HaikuRequest;
use App\Http\Resources\CreateHaikuResource;
use App\Http\Resources\EditHaikuResource;
use App\Http\Resources\IndexHaikuResource;
use App\Models\Haiku;
use App\Models\Theme;
use Illuminate\Http\Request;
/**
 * @OA\Info (
 *     title="Test Haiku",
 *     version="1.0"
 * ),
 * @OA\PathItem (
 *     path="/api"
 * )
 *
 * @OA\Post(
 *  path="/api/haiku",
 *  operationId="createHaiku",
 *  tags={"Haiku"},
 *  summary="Create a new haiku",
 *  description="Create a new haiku entry",
 *  @OA\RequestBody(
 *      required=true,
 *      @OA\JsonContent(
 *          required={"title", "is_hidden", "theme_id", "user_id", "content"},
 *          @OA\Property(property="title", type="string", maxLength=255, example="Example Title"),
 *          @OA\Property(property="is_hidden", type="boolean", example=0),
 *          @OA\Property(property="theme_id", type="integer", example=1),
 *          @OA\Property(property="user_id", type="integer", example=1),
 *          @OA\Property(property="content", type="string", example="Line 1\nLine 2\nLine 3\nLine 4"),
 *          ),
 *      ),
 *      @OA\Response(
 *          response=201,
 *          description="Haiku created successfully",
 *          @OA\JsonContent(
 *          @OA\Property(property="id", type="integer", example=1),
 *          @OA\Property(property="title", type="string", maxLength=255, example="Example Title"),
 *          @OA\Property(property="is_hidden", type="boolean", example=false),
 *          @OA\Property(property="theme_id", type="integer", example=1),
 *          @OA\Property(property="user_id", type="integer", example=1),
 *          @OA\Property(property="content", type="string", example="Line 1\nLine 2\nLine 3\nLine 4"),
 *          ),
 *      ),
 *      @OA\Response(
 *          response=422,
 *          description="Validation error",
 *          @OA\JsonContent(
 *          @OA\Property(property="message", type="string", example="The given data was invalid."),
 *          @OA\Property(property="errors", type="object",
 *          @OA\Property(property="field_name", type="array",
 *          @OA\Items(type="string", example="Error message"),
 *          ),
 *          ),
 *      ),
 *  ),
 * )
 *
 * @OA\Get(
 *      path="/api/v1/haiku",
 *      summary="Get all haiku",
 *      tags={"Haiku"},
 *      security={{ "bearerAuth": {} }},
 *      @OA\Response(
 *          response=200,
 *          description="List of haiku",
 *          @OA\JsonContent(
 *              type="array",
 *              @OA\Items(
 *                   @OA\Property(property="id", type="integer", example=1),
 *                  @OA\Property(property="title", type="string", maxLength=255, example="Example Title"),
 *                  @OA\Property(property="is_hidden", type="boolean", example=false),
 *                  @OA\Property(property="theme_id", type="integer", example=1),
 *                  @OA\Property(property="user_id", type="integer", example=1),
 *                  @OA\Property(property="content", type="string", example="Line 1\nLine 2\nLine 3\nLine 4"),
 *              )
 *          )
 *      ),
 *      @OA\Response(
 *          response=401,
 *          description="Unauthorized",
 *          @OA\JsonContent(
 *          example={"message": "Unauthenticated"}
 *          )
 *      ),
 * )
 *
 * @OA\Delete(
 *      path="/api/haiku/{slug}",
 *      tags={"Haiku"},
 *      summary="Delete a haiku",
 *      description="Deletes a haiku by its slug",
 *      @OA\Parameter(
 *          name="slug",
 *          in="path",
 *          required=true,
 *          description="Slug of the haiku to delete",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *      @OA\Response(
 *          response=204,
 *          description="Haiku deleted successfully"
 *      ),
 *      @OA\Response(
 *          response=404,
 *          description="Haiku not found"
 *      )
 *  )
 *
 * @OA\Put(
 *      path="/api/haiku/{slug}",
 *      tags={"Haiku"},
 *      summary="Update a haiku",
 *      description="Update a haiku entry by its slug",
 *      @OA\Parameter(
 *          name="slug",
 *          in="path",
 *          required=true,
 *          description="Slug of the haiku to update",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(
 *              required={"title", "is_hidden", "theme_id", "user_id", "content"},
 *              @OA\Property(property="title", type="string", maxLength=255, example="Updated Title"),
 *              @OA\Property(property="is_hidden", type="boolean", example=0),
 *              @OA\Property(property="theme_id", type="integer", example=2),
 *              @OA\Property(property="user_id", type="integer", example=2),
 *              @OA\Property(property="content", type="string", example="Updated Line 1\nUpdated Line 2\nUpdated Line 3\nUpdated Line 4"),
 *          ),
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Haiku updated successfully",
 *          @OA\JsonContent(
 *              @OA\Property(property="id", type="integer", example=1),
 *              @OA\Property(property="title", type="string", maxLength=255, example="Updated Title"),
 *              @OA\Property(property="is_hidden", type="boolean", example=false),
 *              @OA\Property(property="theme_id", type="integer", example=2),
 *              @OA\Property(property="user_id", type="integer", example=2),
 *              @OA\Property(property="content", type="string", example="Updated Line 1\nUpdated Line 2\nUpdated Line 3\nUpdated Line 4"),
 *          ),
 *      ),
 *      @OA\Response(
 *          response=422,
 *          description="Validation error",
 *          @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="The given data was invalid."),
 *              @OA\Property(property="errors", type="object",
 *                  @OA\Property(property="field_name", type="array",
 *                      @OA\Items(type="string", example="Error message"),
 *                  ),
 *              ),
 *          ),
 *      ),
 *  )
 */
class HaikuController extends Controller
{

}
