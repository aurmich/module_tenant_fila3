<?php

declare(strict_types=1);

namespace Modules\Media\Handlers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Modules\Media\Dto\MediaLibraryRequestItem;
use Modules\Media\Dto\PendingMediaItem;
use Modules\Media\Models\Media;
use Spatie\MediaLibrary\HasMedia;

class MediaLibraryRequestHandler
{
    protected Model $model;

    protected array $existingUuids;

    protected Collection $mediaLibraryRequestItems;

    protected string $collectionName;

    protected function __construct(Model $model, Collection $mediaLibraryRequestItems, string $collectionName)
    {
        $this->model = $model;
        if (! $this->model instanceof HasMedia) {
            throw new \Exception('['.__LINE__.']['.__FILE__.']');
        }

        $this->existingUuids = $this->model->getMedia($collectionName)->pluck('uuid')->toArray();

        $this->mediaLibraryRequestItems = $mediaLibraryRequestItems;

        $this->collectionName = $collectionName;
    }

    public static function createForMediaLibraryRequestItems(
        Model $model,
        Collection $mediaLibraryRequestItems,
        string $collectionName
    ): self {
        // prima era new static
        return new self($model, $mediaLibraryRequestItems, $collectionName);
    }

    public function updateExistingMedia(): self
    {
        $this
            ->existingMediaLibraryRequestItems()
            ->each(
                function (MediaLibraryRequestItem $mediaResponseItem) {
                    $this->handleExistingMediaLibraryRequestItem($mediaResponseItem);
                }
            );

        return $this;
    }

    public function deleteObsoleteMedia(): self
    {
        $keepUuids = $this->mediaLibraryRequestItems->pluck('uuid')->toArray();

        $this->model->getMedia($this->collectionName)
            ->reject(fn (Media $media) => \in_array($media->uuid, $keepUuids, true))
            ->each(fn (Media $media) => $media->delete());

        return $this;
    }

    public function getPendingMediaItems(): Collection
    {
        return $this
            ->newMediaLibraryRequestItems()
            ->map(
                function (MediaLibraryRequestItem $item) {
                    return new PendingMediaItem(
                        $item->uuid,
                        $item->name,
                        $item->order,
                        $item->customProperties,
                        $item->customHeaders,
                        $item->fileName,
                    );
                });
    }

    protected function existingMediaLibraryRequestItems(): Collection
    {
        return $this
            ->mediaLibraryRequestItems
            ->filter(fn (MediaLibraryRequestItem $item) => \in_array($item->uuid, $this->existingUuids, true));
    }

    protected function newMediaLibraryRequestItems(): Collection
    {
        return $this
            ->mediaLibraryRequestItems
            ->reject(fn (MediaLibraryRequestItem $item) => \in_array($item->uuid, $this->existingUuids, true));
    }

    protected function handleExistingMediaLibraryRequestItem(MediaLibraryRequestItem $mediaLibraryRequestItem): void
    {
        $mediaModelClass = config('media-library.media_model');

        $media = $mediaModelClass::findByUuid($mediaLibraryRequestItem->uuid);

        $media->update([
            'name' => $mediaLibraryRequestItem->name,
            'custom_properties' => $mediaLibraryRequestItem->customProperties,
            'order_column' => $mediaLibraryRequestItem->order,
        ]);
    }
}
