<?php

namespace App\Filament\Resources\PageResource\Pages;

use App\Filament\Resources\PageResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreatePage extends CreateRecord
{
    protected static string $resource = PageResource::class;

    /**
     * Ensure all blocks have UUIDs before save (Filament v3 safe).
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (!empty($data['blocks'])) {
            foreach ($data['blocks'] as &$block) {
                if (empty($block['uuid'])) {
                    $block['uuid'] = (string) Str::uuid();
                }
            }
        }
        return $data;
    }

    /**
     * After save — make sure all media collections
     * use the correct UUID-based naming convention.
     */
    protected function afterCreate(): void
    {
        $page = $this->record;

        foreach ($page->blocks as $pageBlock) {
            $content = $pageBlock->content ?? [];
            if (!is_array($content)) continue;

            $blockDef = $pageBlock->block;
            if (!$blockDef || empty($blockDef->schema)) continue;

            $blockSlug = $blockDef->slug ?? "block_{$pageBlock->id}";
            $pageBlockUuid = $pageBlock->uuid ?: Str::uuid()->toString();

            if (!$pageBlock->uuid) {
                $pageBlock->updateQuietly(['uuid' => $pageBlockUuid]);
            }

            foreach ($content as $index => $blockItem) {
                $content[$index]['uuid'] = $pageBlockUuid;
                $data = $blockItem['data'] ?? [];
                $content[$index]['data'] = $this->mapMediaToDataRecursive(
                    $data,
                    $blockDef->schema,
                    $pageBlock,
                    $blockSlug,
                    $pageBlockUuid
                );
            }

            $validUuids = $this->collectUuidsFromContent($content);
            $this->syncMediaCollectionsToValidUuids($pageBlock, $blockSlug, $validUuids, $pageBlockUuid);

            $pageBlock->updateQuietly(['content' => $content]);
        }
    }

    /**
     * Same recursive mapper used in EditPage.
     */
    protected function mapMediaToDataRecursive(array $data, array $schema, $pageBlock, string $blockSlug, string $currentUuid): array
    {
        foreach ($schema as $field) {
            $fieldKey  = $field['key'] ?? null;
            $fieldType = $field['type'] ?? null;

            if (!$fieldKey) continue;

            if ($fieldType === 'repeater' && isset($data[$fieldKey]) && is_array($data[$fieldKey])) {
                $subSchema = $field['fields'] ?? $field['subfields'] ?? [];
                foreach ($data[$fieldKey] as $i => $subItem) {
                    $subUuid = $subItem['uuid'] ?? Str::uuid()->toString();
                    $subItem['uuid'] = $subUuid;

                    $data[$fieldKey][$i] = $this->mapMediaToDataRecursive(
                        $subItem,
                        $subSchema,
                        $pageBlock,
                        $blockSlug,
                        $subUuid
                    );
                }
            }

            if (in_array($fieldType, ['image', 'file'])) {
                $suffix = $fieldType === 'image' ? 'images' : 'files';
                $collectionName = "blocks_{$blockSlug}_{$currentUuid}_{$suffix}";
                $mediaItems = $pageBlock->getMedia($collectionName);
                if ($mediaItems->isNotEmpty()) {
                    $data[$fieldKey] = $mediaItems->pluck('id')->toArray();
                }
            }
        }
        return $data;
    }

    /**
     * Collect all UUIDs recursively from content.
     */
    protected function collectUuidsFromContent(array $content): array
    {
        $uuids = [];
        $walker = function ($node) use (&$walker, &$uuids) {
            if (!is_array($node)) return;

            if (isset($node['uuid']) && is_string($node['uuid'])) {
                $uuids[] = $node['uuid'];
            }

            foreach ($node as $v) {
                if (is_array($v)) {
                    if (array_values($v) !== $v) {
                        $walker($v);
                    } else {
                        foreach ($v as $child) {
                            $walker($child);
                        }
                    }
                }
            }
        };

        foreach ($content as $item) {
            $walker($item);
        }

        return array_values(array_unique($uuids));
    }

    /**
     * Rename or reassign orphaned media collections to correct UUIDs.
     */
    protected function syncMediaCollectionsToValidUuids($pageBlock, string $blockSlug, array $validUuids, string $fallbackUuid): void
    {
        $suffixes = ['images', 'files'];

        foreach ($suffixes as $suffix) {
            $mediaItems = $pageBlock->media()
                ->where('collection_name', 'like', "blocks_{$blockSlug}_%_{$suffix}")
                ->get();

            foreach ($mediaItems as $media) {
                if (preg_match("/^blocks_".preg_quote($blockSlug,"/")."_(.+)_{$suffix}$/", $media->collection_name, $m)) {
                    $mediaUuid = $m[1];
                } else {
                    $mediaUuid = null;
                }

                if ($mediaUuid && in_array($mediaUuid, $validUuids, true)) {
                    $correctCollection = "blocks_{$blockSlug}_{$mediaUuid}_{$suffix}";
                    if ($media->collection_name !== $correctCollection) {
                        $media->update(['collection_name' => $correctCollection]);
                    }
                } else {
                    $newCollection = "blocks_{$blockSlug}_{$fallbackUuid}_{$suffix}";
                    if ($media->collection_name !== $newCollection) {
                        $media->update(['collection_name' => $newCollection]);
                    }
                }
            }
        }
    }
}
