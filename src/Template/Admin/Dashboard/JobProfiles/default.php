<?php

use OMT\Services\Date;
use OMT\View\Admin\Dashboard\JobProfilesView;
use OMT\View\Components\ModalView;

?>
<div x-ref="root" data-url="<?php echo admin_url('admin-ajax.php') ?>">
    <div class="x-flex x-items-start x-justify-between">
        <h2 class="x-flex-25">Job-Profile</h2>

        <a href="/admin/job-profiles/export/" class="button button-red">Export</a>
    </div>
    <div x-show="availableFilters" class="x-flex x-justify-between x-mb-2">
        <div class="x-flex x-items-center x-justify-end omt-form-group x-mr-4">
            <label for="filter_zip" class="x-mr-4 label">PLZ:</label>

            <input 
                type="search" 
                class="input x-w-24" 
                id="filter_zip" 
                x-model="zip"
            />

            <button 
                type="button" 
                class="x-absolute x-bg-transparent x-border-0 x-text-2xl" 
                @click="zip = ''"
            >&times;</button>
        </div>

        <div class="x-flex x-items-start omt-form-group">
            <select class="dropdown" x-model="filterSelect.key" @change="filterSelect.value = 0">
                <option value="0" disabled>Bitte auswählen</option>

                <template x-for="(filter, field) in availableFilters">
                    <option :value="field" x-text="filter.label"></option>
                </template>
            </select>

            <select class="dropdown x-ml-4 x-text-center x-w-16" x-model="filterSelect.operator">
                <template x-for="operator in filterSelectOperators()">
                    <option :value="operator" x-text="operator"></option>
                </template>
            </select>

            <template x-if="filterSelectType() == 'select'">
                <select class="dropdown x-ml-4" x-model="filterSelect.value">
                    <option value="0" disabled>Bitte auswählen</option>

                    <template x-for="(option, index) in filterSelectValues()">
                        <option :value="index" x-text="option"></option>
                    </template>
                </select>
            </template>

            <template x-if="filterSelectType() == 'date'">
                <input 
                    type="date" 
                    max="<?php echo Date::get()->format('Y-m-d') ?>"
                    x-model="filterSelect.value"
                    class="input x-ml-4 x-w-1_2"
                >
            </template>
            
            <button
                type="button"
                class="button x-ml-4 x-leading-snug x-whitespace-nowrap"
                @click="addFilter()"
            >
                Filter hinzufügen
            </button>
        </div>
    </div>

    <div x-show="filters.length" class="x-mb-4 x-flex x-items-center x-flex-wrap">
        <div class="x-mr-1 x-mb-1">
            Angewandte Filter:
        </div>

        <template x-for="(filter, index) in filters">
            <div class="x-bg-light-grey x-pl-2 x-pr-2 x-rounded x-text-sm x-mr-1 x-mb-1">
                <span x-text="availableFilters[filter.key].label" class="x-text-red-800"></span>: 
                <span x-text="filter.operator" x-show="filter.operator != '='"></span>

                <template x-if="availableFilters[filter.key].type == 'select'">
                    <span x-text="availableFilters[filter.key].options[filter.value]"></span>
                </template>

                <template x-if="availableFilters[filter.key].type == 'date'">
                    <span x-text="formatDate(filter.value)"></span>
                </template>

                <button
                    type="button"
                    class="x-bg-transparent x-border-0 x-pl-0 x-pr-0"
                    @click="deleteFilter(index)"
                >
                    <svg class="x-align-middle x-h-4 x-w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18">
                        <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"/>
                    </svg>
                </button>
            </div>
        </template>
    </div>

    <div class="x-relative">
        <!-- Loading -->
        <div x-show="loading" class="x-absolute x-bg-gray-200 x-bottom-0 x-flex x-flex-col x-items-center x-justify-center x-left-0 x-opacity-75 x-overflow-hidden x-right-0 x-top-0 x-w-full x-z-999">
            <svg class="x-animate-spin x-w-16 x-align-middle" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="x-opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="x-opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <h2 class="x-text-center x-text-xl x-pt-4">Wird geladen...</h2>
        </div>

        <div class="x-overflow-x-auto">
            <table class="x-w-auto">
                <thead>
                    <tr>
                        <th>Anrede</th>
                        <th>Vorname</th>
                        <th>Nachname</th>
                        <th>E-Mail</th>
                        <th>Telefonnummer</th>
                        <th>Aktuelle Position</th>
                        <th>Aktueller Bereich</th>
                        <th>Aktuelle Branche</th>
                        <th>Berufserfahrung Online Marketing</th>
                        <th>Aktueller Job-Status</th>
                        <th>Aktuelles Jahresgehalt</th>
                        <th>Straße + HausNr.</th>
                        <th>Postleitzahl</th>
                        <th>Stadt</th>
                        <th>Geburtsdatum</th>
                        <th class="x-w-16"></th>
                    </tr>
                </thead>
                <tbody>
                    <template x-if="items.length">
                        <template x-for="item in items">
                            <tr>
                                <td x-text="item.salutation"></td>
                                <td x-text="item.firstname"></td>
                                <td x-text="item.lastname"></td>
                                <td x-text="item.email"></td>
                                <td x-text="item.phone"></td>
                                <td x-text="item.position"></td>
                                <td x-text="item.marketing_area ? enums.marketing[item.marketing_area] : '-'"></td>
                                <td x-text="item.branch ? enums.branch[item.branch] : '-'"></td>
                                <td x-text="item.experience ? enums.experience[item.experience] : '-'"></td>
                                <td x-text="item.job_status ? enums.job_status[item.job_status] : '-'"></td>
                                <td x-text="item.annual_salary ? enums.annual_salary[item.annual_salary] : '-'"></td>
                                <td x-text="item.address"></td>
                                <td x-text="item.zip"></td>
                                <td x-text="item.city"></td>
                                <td x-text="item.birthdate ? formatDate(item.birthdate) : '-'"></td>
                                <td>
                                    <button @click="details = item; $dispatch('open-modal')" type="button" class="x-border-0 x-bg-transparent" title="Einzelheiten">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="x-h-6 x-w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        </template>
                    </template>
                    <template x-if="!items.length">
                        <tr>
                            <td colspan="15">
                                Keine Jobprofile gefunden
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>

    <?php echo ModalView::loadTemplate('default', [
        'scripts' => false,
        'title' => 'Job-Profile Einzelheiten',
        'content' => JobProfilesView::loadTemplate('details')
    ]) ?>
</div>