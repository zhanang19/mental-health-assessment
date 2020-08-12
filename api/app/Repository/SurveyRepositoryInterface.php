<?php

namespace App\Repository;

use App\Survey;
use Illuminate\Support\Collection;

interface SurveyRepositoryInterface
{
    /**
     * Get all survey forms.
     *
     * @return Collection
     */
    public function all(): Collection;

    /**
     * Find survey by id.
     *
     * @param int $id
     * @return Survey
     */
    public function findById(int $id): ?Survey;

    /**
     * Find trashed by id.
     *
     * @param int $id
     * @return Survey
     */
    public function findTrashedById(int $id): ?Survey;

    /**
     * Get survey by slug.
     *
     * @param string $slug
     * @return Survey
     */
    public function findBySlug(string $slug): ?Survey;

    /**
     * Find trashed survey by slug.
     *
     * @param string $slug
     * @return Survey
     */
    public function findTrashedBySlug(string $slug): ?Survey;

    /**
     * Create new survey.
     *
     * @return Survey
     */
    public function createSurvey();

    /**
     * Update existing survey.
     *
     * @param int $id
     * @param array $payload
     * @return Survey
     */
    public function updateSurvey(int $id, $payload);

    /**
     * Delete survey by id.
     *
     * @param int $id
     * @return boolean
     */
    public function deleteById(int $id);

    /**
     * @param int $id
     * @return boolean
     */
    public function deletePermanentlyById(int $id);

    /**
     * Delete survey by slug.
     *
     * @param string $slug
     * @return boolean
     */
    public function deleteBySlug(string $slug);

    /**
     * @param int $id
     * @return boolean
     */
    public function deletePermanentlyBySlug(string $slug);

    /**
     * Restore survey by id.
     *
     * @param int $id
     * @return boolean
     */
    public function restoreById(int $id);

    /**
     * Restore survey by slug.
     *
     * @param string $slug
     * @return boolean
     */
    public function restoreBySlug(string $slug);
}
