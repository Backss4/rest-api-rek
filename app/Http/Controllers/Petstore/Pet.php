<?php

namespace App\Http\Controllers\Petstore;

use Exception;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Client\ConnectionException;


use App\Http\Controllers\Controller;
use App\Services\Petstore\Petstore;
use App\Services\Petstore\DataTransferObjects\Pet as PetDTO;
use App\Services\Petstore\DataTransferObjects\Category;
use App\Services\Petstore\DataTransferObjects\Status;
use App\Services\Petstore\DataTransferObjects\Tag;
use App\Services\Petstore\Exceptions\RequestException;
use App\Services\Petstore\Exceptions\MalformedResponseException;


class Pet extends Controller
{
    public function __construct(
        protected Petstore $petstore,
    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return response()->view('petstore.pet.home');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $statuses = Status::cases();
        return response()->view('petstore.pet.create', compact('statuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): Response
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'category' => 'string|nullable',
            'status' => ['required', Rule::enum(Status::class)],
        ]);

        try {
            $category = null;

            if(!is_null($validated['category'])) {
                $category = new Category(rand(1, 2000), $validated['category']);
            }

            $dto = new PetDTO(
                rand(1, 2000),
                $validated['name'],
                $category,
                collect([]),
                collect([]),
                Status::from($validated['status']),
            );

            $pet = $this->petstore->pet()->create($dto);
            return redirect()->route('pet.show', ['id' => $pet->id])
                ->with(['message' => 'Pet created with id: ' . $pet->id . '.']);
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        try {
            $pet = $this->petstore->pet()->get($id);
            return response()->view('petstore.pet.show', compact('pet'));
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }
    }

    /**
     * Validate search form.
     */
    public function search(Request $request): Response
    {
        $validated = $request->validate([
            'id' => 'required|integer',
        ]);

        echo $validated["id"];

        return to_route('pet.show', ['id' => $validated["id"]]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): Response
    {
        try {
            $pet = $this->petstore->pet()->get($id);
            $statuses = Status::cases();
            return response()->view('petstore.pet.edit.pet', compact('pet', 'statuses'));
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): Response
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'status' => ['required', Rule::enum(Status::class)],
        ]);

        try {
            $this->petstore->pet()->partialUpdate($id, $validated['name'], Status::from($validated['status']));
            return redirect()->route('pet.show', compact('id'))
                ->with(['message' => 'Pet saved.']);
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): Response
    {
        try {
            $this->petstore->pet()->delete($id);
            return redirect()->route('pet.index')->with(['message' => 'Pet deleted.']);
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }
    }

    public function editCategory(int $id): Response
    {
        try {
            $pet = $this->petstore->pet()->get($id);
            return response()->view('petstore.pet.edit.category', compact('pet'));
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }
    }

    public function updateCategory(Request $request, int $id): Response
    {
        $validated = $request->validate([
            'id' => 'required|integer|min:1',
            'name' => 'required|string',
        ]);

        try {
            $pet = $this->petstore->pet()->get($id);
            $pet->category = new Category((int) $validated['id'], $validated['name']);
            $this->petstore->pet()->update($pet);

            return redirect()->route('pet.show', compact('id'))
                ->with(['message' => 'Category updated.']);
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }
    }

    public function addTag(int $id): Response
    {
        try {
            $pet = $this->petstore->pet()->get($id);
            return response()->view('petstore.pet.add.tag', compact('pet'));
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }
    }

    public function storeTag(Request $request, int $id): Response
    {
        $validated = $request->validate([
            'name' => 'required|string',
        ]);

        try {
            $pet = $this->petstore->pet()->get($id);
            $pet->tags->push(new Tag(rand(1, 2000), $validated['name']));
            $this->petstore->pet()->update($pet);

            return redirect()->route('pet.show', compact('id'))
                ->with(['message' => 'Tag added.']);
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }
    }

    public function addPhoto(int $id): Response
    {
        try {
            $pet = $this->petstore->pet()->get($id);
            return response()->view('petstore.pet.add.photo', compact('pet'));
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }
    }

    public function storePhoto(Request $request, int $id): Response
    {
        $validated = $request->validate([
            'photo_url' => 'required|url:http,https',
        ]);

        try {
            $pet = $this->petstore->pet()->get($id);
            $pet->photoUrls->push($validated['photo_url']);
            $this->petstore->pet()->update($pet);

            return redirect()->route('pet.show', compact('id'))
                ->with(['message' => 'Photo URL added.']);

        } catch (Exception $exception) {
            return $this->handleException($exception);
        }
    }


    public function removeTag(int $id): Response
    {
        try {
            $pet = $this->petstore->pet()->get($id);
            return response()->view('petstore.pet.remove.tag', compact('pet'));
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }
    }

    public function destroyTag(Request $request, int $id): Response
    {
        $validated = $request->validate([
            'tag_id' => 'required|integer',
        ]);

        try {
            $pet = $this->petstore->pet()->get($id);
            $found = $pet->tags->search(function (Tag $item, int $key) use ($validated) {
                return $item->id === (int) $validated["tag_id"];
            });

            if ($found !== false) {
                $pet->tags->forget($found);
                $this->petstore->pet()->update($pet);
                return redirect()->route('pet.show', compact('id'))
                    ->with(['message' => 'Tag deleted.']);
            }

            return redirect()->route('pet.remove.tag', compact('id'))
                ->with(['message' => 'Tag not found.']);
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }
    }

    public function removePhoto(int $id): Response
    {
        try {
            $pet = $this->petstore->pet()->get($id);
            return response()->view('petstore.pet.remove.photo', compact('pet'));
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }
    }

    public function destroyPhoto(Request $request, int $id): Response
    {
        $validated = $request->validate([
            'photo_url' => 'required|string',
        ]);

        try {
            $pet = $this->petstore->pet()->get($id);
            $found = $pet->photoUrls->search($validated["photo_url"]);

            if ($found !== false) {
                $pet->photoUrls->forget($found);
                $this->petstore->pet()->update($pet);
                return redirect()->route('pet.show', compact('id'))
                    ->with(['message' => 'Photo URL deleted.']);
            }

            return redirect()->route('pet.remove.tag', compact('id'))
                ->with(['message' => 'Photo URL not found.']);
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }
    }


    protected function handleRequestException(RequestException $exception): array
    {
        $code = $exception->response->status();
        if ($exception->response->serverError()) {
            return [$code, $exception->apiResponse?->message ?? 'API Server error occurred.'];
        }

        return [$code, $exception->apiResponse?->message ?? $exception->getMessage()];
    }


    /**
     * @throws Exception
     */
    protected function handleException(Exception $exception): Response
    {
        if(!app()->hasDebugModeEnabled()) {
            [$code, $message] = match (true) {
                $exception instanceof RequestException => $this->handleRequestException($exception),
                $exception instanceof MalformedResponseException => [Response::HTTP_INTERNAL_SERVER_ERROR, 'Malformed data in API response.'],
                $exception instanceof ConnectionException => [Response::HTTP_GATEWAY_TIMEOUT, 'A request to the API could not be made.'],
                default => throw $exception
            };

            return response()->view('petstore.pet.error', compact('message'), $code);
        }
        throw $exception;
    }
}
