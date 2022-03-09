
<?php

use OMT\Ajax\Admin\CreateToolProviderUser;

acf_form_head();
wp_enqueue_script('alpinejs', get_template_directory_uri() . '/library/js/libs/alpine.min.js');
CreateToolProviderUser::getInstance()->enqueueScripts();
?>
<div 
    x-data="xCreateToolProviderUser()"
    class="module module-backend-area create-tool-provider-user-section"
>
    <h2 id="toolarea-headline">Neuen Toolanbieter-Benutzer hinzufügen</h2>

    <div x-ref="alertContainer" class="x-w-full">
        <div 
            x-cloak 
            x-show="notice" 
            class="x-text-left x-mb-4 x-pl-2 x-pr-2 x-pt-2 x-pb-2 x-rounded x-items-center x-shadow x-flex x-w-full"
            :class="noticeType == 'error' ? 'x-text-red-600 x-bg-red-50' : 'x-text-green-600 x-bg-green-50'"
        >
            <div class="x-flex">
                <svg xmlns="http://www.w3.org/2000/svg" class="x-fill-current x-w-5" viewBox="0 0 24 24">
                    <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-1.959 17l-4.5-4.319 1.395-1.435 3.08 2.937 7.021-7.183 1.422 1.409-8.418 8.591z"/>
                </svg>
            </div>

            <div
                x-text="message"
                class="x-flex-1 x-ml-4"
                :class="noticeType == 'error' ? 'x-text-red-800' : 'x-text-green-800'"
            ></div>
        </div>
    </div>

    <table class="form-table">
        <tbody>
            <tr>
                <td class="x-leading-9 x-w-56">
                    <label for="first_name"><strong>First Name</strong> <span class="x-text-red-600">*</span></label>
                </td>
                <td>
                    <input type="text" name="first_name" id="first_name" class="x-pb-2 x-pl-2 x-pr-2 x-pt-2 x-w-1_2" x-model="data.first_name">
                </td>
            </tr>
            <tr>
                <td class="x-leading-9 x-w-56">
                    <label for="last_name"><strong>Last Name</strong> <span class="x-text-red-600">*</span></label>
                </td>
                <td>
                    <input type="text" name="last_name" id="last_name" class="x-pb-2 x-pl-2 x-pr-2 x-pt-2 x-w-1_2" x-model="data.last_name">
                </td>
            </tr>
            <tr>
                <td class="x-leading-9 x-w-56">
                    <label for="email"><strong>Email</strong> <span class="x-text-red-600">*</span></label>
                </td>
                <td>
                    <input type="email" name="email" id="email" class="x-pb-2 x-pl-2 x-pr-2 x-pt-2 x-w-1_2" x-model="data.email">
                </td>
            </tr>
            <tr>
                <td class="x-leading-9 x-w-56">
                    <label for="password"><strong>Password</strong> <span class="x-text-red-600">*</span></label>
                </td>
                <td>
                    <input type="password" name="password" id="password" class="x-pb-2 x-pl-2 x-pr-2 x-pt-2 x-w-1_2" x-model="data.password">
                </td>
            </tr>
            <tr>
                <td class="x-leading-9 x-w-56">
                    <label for="firma"><strong>Company</strong> <span class="x-text-red-600">*</span></label>
                </td>
                <td>
                    <input type="text" name="firma" id="firma" class="x-pb-2 x-pl-2 x-pr-2 x-pt-2 x-w-1_2" x-model="data.firma">
                </td>
            </tr>
            <tr x-ref="tools">
                <td class="x-leading-9 x-w-56">
                    <label><strong>Assigned Tool</strong> <span class="x-text-red-600">*</span></label>
                </td>
                <?php
                    acf_form([
                        'form' => false,
                        'fields' => ['zugewiesenes_tool'],
                        'field_el' => 'td'
                    ]);
                ?>
            </tr>
            <tr>
                <td class="x-leading-9 x-w-56">
                    <label for="deposit"><strong>Startguthaben</strong></label>
                </td>
                <td>
                    <input type="number" name="deposit" id="deposit" class="x-pb-2 x-pl-2 x-pr-2 x-pt-2 x-w-1_2" min="0" step="0.01" x-model="data.deposit">
                </td>
            </tr>
            <tr>
                <td class="x-leading-9 x-w-56">
                    <label><strong>Profilseite Tracking-Links</strong></label>

                    <div class="x-text-sm x-text-red-600">
                        Note: If URLs for assigned tool already exists they will be updated
                    </div>
                </td>
                <td>
                    <div class="x-flex x-items-center x-mb-4">
                        <label for="website_url" class="x-w-24">Website:</label>
                        <input type="text" name="website_url" id="website_url" class="x-pb-2 x-pl-2 x-pr-2 x-pt-2 x-w-1_2" x-model="website_url">
                    </div>

                    <div class="x-flex x-items-center x-mb-4">
                        <label for="prices_url" class="x-w-24">Preise:</label>
                        <input type="text" name="prices_url" id="prices_url" class="x-pb-2 x-pl-2 x-pr-2 x-pt-2 x-w-1_2" x-model="prices_url">
                    </div>

                    <div class="x-flex x-items-center x-mb-4">
                        <label for="test_url" class="x-w-24">Testversion:</label>
                        <input type="text" name="test_url" id="test_url" class="x-pb-2 x-pl-2 x-pr-2 x-pt-2 x-w-1_2" x-model="test_url">
                    </div>
                </td>
            </tr>
            <tr x-ref="tracking-links">
                <td class="x-leading-9 x-w-56">
                    <label for="test_url"><strong>Tool Kategorien Links</strong></label>

                    <div class="x-text-sm x-text-red-600">
                        Note: If URLs for assigned tool categories already exists they will be updated
                    </div>
                </td>
                <?php
                    acf_form([
                        'form' => false,
                        'fields' => ['tool_kategorien'],
                        'field_el' => 'td'
                    ]);
                ?>
            </tr>
            <tr>
                <td class="x-leading-9 x-w-56">
                    <label for="activate_buttons"><strong>Buttons aktivieren</strong></label>
                </td>
                <td>
                    <input type="checkbox" name="activate_buttons" id="activate_buttons" x-model="data.activate_buttons">
                </td>
            </tr>
        </tbody>
    </table>

    <div class="x-flex x-justify-end x-w-full">
        <button 
            type="button"
            class="button button-dark-blue"
            @click="save()"
            :disabled="loading"
        >
            <svg x-show="loading" class="x-animate-spin x-h-5 x-w-5 x-leading-9 x-mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="x-opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="x-opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>

            Speichern
        </button>
    </div>
</div>
