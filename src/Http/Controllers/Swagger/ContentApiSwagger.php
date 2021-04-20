<?php

namespace EscolaLms\HeadlessH5P\Http\Controllers\Swagger;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use EscolaLms\HeadlessH5P\Http\Requests\ContentStoreRequest;

    /**
     * @OA\Schema(
     *      schema="H5PContentStore",
     *      type="object",
     *      @OA\Property(
     *          property="title",
     *          description="Title of new content",
     *          type="string"
     *      ),
     *      @OA\Property(
     *          property="library",
     *          description="ubername of library",
     *          type="string"
     *      ),
     *      @OA\Property(
     *          property="params",
     *          description="params taken from editor",
     *          type="string"
     *      ),
     *      @OA\Property(
     *          property="nonce",
     *          description="nonce taken from editor settings (random for new, hash for exisiting)",
     *          type="string"
     *      ),
     * )
    */

    /**
     *
     * @OA\Schema(
     *      schema="H5PContentList",
     *      type="object",
     *      @OA\Property(
     *          property="current_page",
     *          type="integer"
     *      ),
     *      @OA\Property(
     *          property="first_page_url",
     *          type="string"
     *      ),
     *      @OA\Property(
     *          property="last_page",
     *          type="integer"
     *      ),
     *      @OA\Property(
     *          property="last_page_url",
     *          type="string"
     *      ),
     *      @OA\Property(
     *          property="next_page_url",
     *          type="string"
     *      ),
     *      @OA\Property(
     *          property="path",
     *          type="string"
     *      ),
     *      @OA\Property(
     *          property="per_page",
     *          type="integer"
     *      ),
     *      @OA\Property(
     *          property="prev_page_url",
     *          type="string"
     *      ),
     *      @OA\Property(
     *          property="to",
     *          type="integer"
     *      ),
     *      @OA\Property(
     *          property="total",
     *          type="integer"
     *      ),
     *      @OA\Property(
     *          property="data",
     *          type="array",
     *          @OA\Items(ref="#/components/schemas/H5PContent")
     *      ),
     * )
     */



interface ContentApiSwagger
{

    /**
    * @OA\Post(
    *      path="/api/hh5p/content",
    *      summary="Store h5p content in database",
    *      tags={"H5P"},
    *      description="Store h5p content in database",
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\MediaType(
    *              mediaType="application/json",
    *              @OA\Schema(ref="#/components/schemas/H5PContentStore")
    *          )
    *      ),
    *      @OA\Response(
    *          response=200,
    *          description="successful operation",
    *          @OA\MediaType(
    *              mediaType="application/json"
    *          )
    *      ),
    *      @OA\Response(
    *          response=422,
    *          description="validation error",
    *          @OA\MediaType(
    *              mediaType="application/json"
    *          )
    *      ),
    *      @OA\Response(
    *          response=401,
    *          description="unauthorised",
    *          @OA\MediaType(
    *              mediaType="application/json"
    *          )
    *      )
    * )
    */
    public function store(ContentStoreRequest $request): JsonResponse;

    /**
    * @OA\Post(
    *      path="/api/hh5p/content/{id}",
    *      summary="Updates h5p content in database",
    *      tags={"H5P"},
    *      description="Updates h5p content in database",
    *      @OA\Parameter(
    *          name="id",
    *          description="Id of Content from DB",
    *          in="path",
    *          required=true,
    *          @OA\Schema(
    *             type="integer",
    *         )
    *      ),
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\MediaType(
    *              mediaType="application/json",
    *              @OA\Schema(ref="#/components/schemas/H5PContentStore")
    *          )
    *      ),
    *      @OA\Response(
    *          response=200,
    *          description="successful operation",
    *          @OA\MediaType(
    *              mediaType="application/json"
    *          )
    *      ),
    *      @OA\Response(
    *          response=422,
    *          description="validation error",
    *          @OA\MediaType(
    *              mediaType="application/json"
    *          )
    *      ),
    *      @OA\Response(
    *          response=401,
    *          description="unauthorised",
    *          @OA\MediaType(
    *              mediaType="application/json"
    *          )
    *      )
    * )
    */
    public function update(ContentStoreRequest $request, int $id): JsonResponse;

    /**
    * @OA\Get(
    *      path="/api/hh5p/content",
    *      summary="list of h5ps content in database",
    *      tags={"H5P"},
    *      description="list of h5ps content in database",
    *      @OA\Parameter(
    *          name="page",
    *          description="page of pagination",
    *          in="query",
    *          required=false,
    *          @OA\Schema(
    *             type="integer",
    *         )
    *      ),
    *      @OA\Parameter(
    *          name="per_page",
    *          description="items per page",
    *          in="query",
    *          required=false,
    *          @OA\Schema(
    *             type="integer",
    *         )
    *      ),
    *      @OA\Response(
    *          response=200,
    *          description="successful operation",
    *          @OA\JsonContent(
    *             type="object",
    *             ref="#/components/schemas/H5PContentList"
    *         )
    *      ),
    *      @OA\Response(
    *          response=422,
    *          description="validation error",
    *          @OA\MediaType(
    *              mediaType="application/json"
    *          )
    *      ),
    *      @OA\Response(
    *          response=401,
    *          description="unauthorised",
    *          @OA\MediaType(
    *              mediaType="application/json"
    *          )
    *      )
    * )
    */
    public function index(ContentStoreRequest $request): JsonResponse;
}
