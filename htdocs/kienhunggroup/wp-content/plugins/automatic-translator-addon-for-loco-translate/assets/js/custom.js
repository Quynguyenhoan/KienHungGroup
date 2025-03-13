const AutoTranslator = (function (window, $) {
    // get Loco Translate global object.  
    const locoConf = window.locoConf;
    // get plugin configuration object.
    const configData = window.extradata;
    const { ajax_url: ajaxUrl, nonce: nonce, ATLT_URL: ATLT_URL, extra_class: rtlClass} = configData;

    onLoad();
    function onLoad() {
        if (locoConf && locoConf.conf) {
            const { conf } = locoConf;
            // get all string from loco translate po data object
            //  const allStrings = conf.podata.slice(1);
            const allStrings = locoConf.conf.podata;
            allStrings.shift();
            const { locale, project } = conf;
            // create a project ID for later use in ajax request.
            const projectId = generateProjectId(project, locale);
            // create strings modal
            const widgetType = 'yandex';
            createStringsModal(projectId, widgetType);
            addStringsInModal(allStrings)
        }
    }

    function initialize() {

        const { conf } = locoConf;
        const { locale, project } = conf;
        // Embbed Auto Translate button inside Loco Translate editor
        if ($("#loco-editor nav").find("#cool-auto-translate-btn").length === 0) {
            addAutoTranslationBtn();
        }

        //append auto translate settings model
        settingsModel();

        // on auto translate button click settings model
        $("#cool-auto-translate-btn").on("click", openSettingsModel);


        $("button.icon-robot[data-loco='auto']").on("click", onAutoTranslateClick);

        $("#atlt_yandex_translate_btn").on("click", function () {
            onYandexTranslateClick(locale);
        });

        // save string inside cache for later use
        $(".atlt_save_strings").on("click", onSaveClick);
    }

    function addStringsInModal(allStrings) {
        const plainStrArr = filterRawObject(allStrings, "plain");
        if (plainStrArr.length > 0) {
            printStringsInPopup(plainStrArr, type = "yandex");
        } else {
            $("#ytWidget").hide();
            $(".notice-container")
                .addClass('notice inline notice-warning')
                .html("There is no plain string available for translations.");
            $(".atlt_string_container, .choose-lang, .translator-widget, .notice-info, .is-dismissible").hide();
        }
    }

    // create project id for later use inside ajax request.
    function generateProjectId(project, locale) {
        const { domain } = project || {};
        const { lang, region } = locale;
        return project ? `${domain}-${lang}-${region}` : `temp-${lang}-${region}`;
    }

    // Yandex click handler
    function onYandexTranslateClick(locale) {
        const defaultcode = locale.lang || null;
        let defaultlang = '';

        const langMapping = {
            'bel': 'be',
            'he': 'iw',
            'snd': 'sd',
            'jv': 'jv',
            'nb': 'no',
            'nn': 'no'
            // Add more cases as needed
        };

        defaultlang = langMapping[defaultcode] || defaultcode;
        let modelContainer = $('div#atlt_strings_model.yandex-widget-container');

        modelContainer.find(".atlt_actions > .atlt_save_strings").prop("disabled", true);
        modelContainer.find(".atlt_stats").hide();

        localStorage.setItem("lang", defaultlang);

        const supportedLanguages = ['af', 'jv', 'no', 'am', 'ar', 'az', 'ba', 'be', 'bg', 'bn', 'bs', 'ca', 'ceb', 'cs', 'cy', 'da', 'de', 'el', 'en', 'eo', 'es', 'et', 'eu', 'fa', 'fi', 'fr', 'ga', 'gd', 'gl', 'gu', 'he', 'hi', 'hr', 'ht', 'hu', 'hy', 'id', 'is', 'it', 'ja', 'jv', 'ka', 'kk', 'km', 'kn', 'ko', 'ky', 'la', 'lb', 'lo', 'lt', 'lv', 'mg', 'mhr', 'mi', 'mk', 'ml', 'mn', 'mr', 'mrj', 'ms', 'mt', 'my', 'ne', 'nl', 'no', 'pa', 'pap', 'pl', 'pt', 'ro', 'ru', 'si', 'sk', 'sl', 'sq', 'sr', 'su', 'sv', 'sw', 'ta', 'te', 'tg', 'th', 'tl', 'tr', 'tt', 'udm', 'uk', 'ur', 'uz', 'vi', 'xh', 'yi', 'zh'];

        if (!supportedLanguages.includes(defaultlang)) {
            $("#atlt-dialog").dialog("close");
            modelContainer.find(".notice-container")
                .addClass('notice inline notice-warning')
                .html("Yandex Automatic Translator Does not support this language.");
            modelContainer.find(".atlt_string_container, .choose-lang, .atlt_save_strings, #ytWidget, .translator-widget, .notice-info, .is-dismissible").hide();
            modelContainer.fadeIn("slow");
        } else {
            $("#atlt-dialog").dialog("close");
            modelContainer.fadeIn("slow");
        }


    }
    // parse all translated strings and pass to save function
    function onSaveClick() {
        let translatedObj = [];

        const rpl = {
            '"% s"': '"%s"',
            '"% d"': '"%d"',
            '"% S"': '"%s"',
            '"% D"': '"%d"',
            '% s': ' %s ',
            '% S': ' %s ',
            '% d': ' %d ',
            '% D': ' %d ',
            '٪ s': ' %s ',
            '٪ S': ' %s ',
            '٪ d': ' %d ',
            '٪ D': ' %d ',
            '٪ س': ' %s ',
            '%S': ' %s ', 
            '%D': ' %d ', 
            '% %':'%%'    
        };
        const regex = /(\%\s*\d+\s*\$?\s*[a-z0-9])/gi;
        
        $(".atlt_strings_table tbody tr").each(function () {
            const source = $(this).find("td.source").text();
            const target = $(this).find("td.target").text();

            const improvedTarget1 = strtr(target, rpl);
            const improvedSource1 = strtr(source, rpl);

            const improvedTarget = improvedTarget1.replace(regex, function(match) {
                return match.replace(/\s/g, '').toLowerCase();
            });

            const improvedSource = improvedSource1.replace(regex, function(match) {
                return match.replace(/\s/g, '').toLowerCase();
            });

            translatedObj.push({
                "source": improvedSource,
                "target": improvedTarget
            });
        });

        var projectId = $(this).parents("#atlt_strings_model").find("#project_id").val();

        //  Save Translated Strings
        saveTranslatedStrings(translatedObj, projectId);

        $(".atlt_custom_model").fadeOut("slow");

        $("html").addClass("merge-translations");
        updateLocoModel();
    }

    function onAutoTranslateClick(e) {
        if (e.originalEvent !== undefined) {
            var checkModal = setInterval(function () {
                var locoModal = $(".loco-modal");
                var locoBatch = locoModal.find("#loco-apis-batch");
                var locoTitle = locoModal.find(".ui-dialog-titlebar .ui-dialog-title");

                if (locoBatch.length && !locoModal.is(":hidden")) {
                    locoModal.removeClass("addtranslations");
                    locoBatch.find("select#auto-api").show();
                    locoBatch.find("a.icon-help, a.icon-group").show();
                    locoBatch.find("#loco-job-progress").show();
                    locoTitle.html("Auto-translate this file");
                    locoBatch.find("button.button-primary span").html("Translate");

                    var opt = locoBatch.find("select#auto-api option").length;

                    if (opt === 1) {
                        locoBatch.find(".noapiadded").remove();
                        locoBatch.removeClass("loco-alert");
                        locoBatch.find("form").hide();
                        locoBatch.addClass("loco-alert");
                        locoTitle.html("No translation APIs configured");
                        locoBatch.append(`<div class='noapiadded'>
                            <p>Add automatic translation services in the plugin settings.<br>or<br>Use <strong>Auto Translate</strong> addon button.</p>
                            <nav>
                                <a href='http://locotranslate.local/wp-admin/admin.php?page=loco-config&amp;action=apis' class='button button-link has-icon icon-cog'>Settings</a>
                                <a href='https://localise.biz/wordpress/plugin/manual/providers' class='button button-link has-icon icon-help' target='_blank'>Help</a>
                                <a href='https://localise.biz/wordpress/translation?l=de-DE' class='button button-link has-icon icon-group' target='_blank'>Need a human?</a>
                            </nav>
                        </div>`);
                    }
                    clearInterval(checkModal);
                }
            }, 100); // check every 100ms
        }
    }

    // update Loco Model after click on merge translation button
    function updateLocoModel() {
        var checkModal = setInterval(function () {
            var locoModel = $('.loco-modal');
            var locoModelApisBatch = $('.loco-modal #loco-apis-batch');
            if (locoModel.length && // model exists check
                locoModel.attr("style").indexOf("none") <= -1 && // has not display none
                locoModel.find('#loco-job-progress').length // element loaded 
            ) {
                $("html").removeClass("merge-translations");
                locoModelApisBatch.find("a.icon-help, a.icon-group, #loco-job-progress").hide();
                locoModelApisBatch.find("select#auto-api").hide();
                var currentState = $("select#auto-api option[value='loco_auto']").prop("selected", "selected");
                locoModelApisBatch.find("select#auto-api").val(currentState.val());
                locoModel.find(".ui-dialog-titlebar .ui-dialog-title").html("Step 3 - Add Translations into Editor and Save");
                locoModelApisBatch.find("button.button-primary span").html("Start Adding Process");
                locoModelApisBatch.find("button.button-primary").on("click", function () {
                    $(this).find('span').html("Adding...");
                });
                locoModel.addClass("addtranslations");
                $('.noapiadded').remove();
                locoModelApisBatch.find("form").show();
                locoModelApisBatch.removeClass("loco-alert");
                clearInterval(checkModal);
            }
        }, 200); // check every 200ms
    }
    // filter string based upon type
    function filterRawObject(rawArray, filterType) {
        return rawArray.filter((item) => {
            if (item.source && !item.target) {
                if (ValidURL(item.source) || isHTML(item.source) || isSpecialChars(item.source) || isEmoji(item.source) || item.source.includes('#')) {
                    return false;
                } else if (isPlacehodersChars(item.source)) {
                    return true;
                } else {
                    return true;
                }
            }
            return false;
        });
    }
    // detect String contain URL
    function ValidURL(str) {
        var pattern = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
        return pattern.test(str);
    }
    // detect Valid HTML in string
    function isHTML(str) {
        var rgex = /<(?=.*? .*?\/ ?>|br|hr|input|!--|wbr)[a-z]+.*?>|<([a-z]+).*?<\/\1>/i;
        return rgex.test(str);
    }
    //  check special chars in string
    function isSpecialChars(str) {
        var rgex = /[@^{}|<>]/g;
        return rgex.test(str);
    }
    //  check Emoji chars in string
    function isEmoji(str) {
        var ranges = [
            '(?:[\u2700-\u27bf]|(?:\ud83c[\udde6-\uddff]){2}|[\ud800-\udbff][\udc00-\udfff]|[\u0023-\u0039]\ufe0f?\u20e3|\u3299|\u3297|\u303d|\u3030|\u24c2|\ud83c[\udd70-\udd71]|\ud83c[\udd7e-\udd7f]|\ud83c\udd8e|\ud83c[\udd91-\udd9a]|\ud83c[\udde6-\uddff]|[\ud83c[\ude01-\ude02]|\ud83c\ude1a|\ud83c\ude2f|[\ud83c[\ude32-\ude3a]|[\ud83c[\ude50-\ude51]|\u203c|\u2049|[\u25aa-\u25ab]|\u25b6|\u25c0|[\u25fb-\u25fe]|\u00a9|\u00ae|\u2122|\u2139|\ud83c\udc04|[\u2600-\u26FF]|\u2b05|\u2b06|\u2b07|\u2b1b|\u2b1c|\u2b50|\u2b55|\u231a|\u231b|\u2328|\u23cf|[\u23e9-\u23f3]|[\u23f8-\u23fa]|\ud83c\udccf|\u2934|\u2935|[\u2190-\u21ff])' // U+1F680 to U+1F6FF
        ];
        return str.match(ranges.join('|'));
    }
    // allowed special chars in plain text
    function isPlacehodersChars(str) {
        var rgex = /%s|%d/g;
        return rgex.test(str);
    }
    // replace placeholders in strings
    function strtr(s, p, r) {
        return !!s && {
            2: function () {
                for (var i in p) {
                    s = strtr(s, i, p[i]);
                }
                return s;
            },
            3: function () {
                return s.replace(RegExp(p, 'g'), r);
            },
            0: function () {
                return;
            }
        }[arguments.length]();
    }

    // Save translated strings in the cache using ajax requests in parts.
    function saveTranslatedStrings(translatedStrings, projectId) {
        // Check if translatedStrings is not empty and has data
        if (translatedStrings && translatedStrings.length > 0) {
            // Define the batch size for ajax requests
            const batchSize = 2500;

            // Iterate over the translatedStrings in batches
            for (let i = 0; i < translatedStrings.length; i += batchSize) {
                // Extract the current batch
                const batch = translatedStrings.slice(i, i + batchSize);
                // Determine the part based on the batch position
                const part = `-part-${Math.ceil(i / batchSize)}`;
                // Send ajax request for the current batch
                sendBatchRequest(batch, projectId, part);

            }

        }
    }


    // send ajax request and save data.
    function sendBatchRequest(stringData, projectId, part) {
        const data = {
            'action': 'save_all_translations',
            'data': JSON.stringify(stringData),
            'part': part,
            'project-id': projectId,
            'wpnonce': nonce
        };

        jQuery.post(ajaxUrl, data, function (response) {
            $('#loco-editor nav').find('button').each(function (i, el) {
                var id = el.getAttribute('data-loco');
                if (id == "auto") {
                    if (!$(el).hasClass('model-opened')) {
                        $(el).addClass('model-opened');
                        $(el).trigger("click");
                    }
                }
            });
        });
    }

    // integrates auto traslator button in editor
    function addAutoTranslationBtn() {
        // check if button already exists inside translation editor
        const existingBtn = $("#loco-editor nav").find("#cool-auto-translate-btn");
        if (existingBtn.length > 0) {
            existingBtn.remove();
        }
        const locoActions = $("#loco-editor nav").find("#loco-actions");
        const autoTranslateBtn = $('<fieldset><button id="cool-auto-translate-btn" class="button has-icon icon-translate">Auto Translate</button></fieldset>');
        // append custom created button.
        locoActions.append(autoTranslateBtn);
    }
    // open settings model on auto translate button click
    function openSettingsModel() {
        $("#atlt-dialog").dialog({
            dialogClass: rtlClass,
            resizable: false,
            height: "auto",
            width: 400,
            modal: true,
            buttons: {
                Cancel: function () {
                    $(this).dialog("close");
                }
            }
        });
    }

    //String Translate Model
    // Get the modal
    var gModal = document.getElementById("atlt_strings_model");
    // When the user clicks anywhere outside of the modal, close it
    $(window).click(function (event) {
        if (event.target == gModal) {
            gModal.style.display = "none";
        }
    });
    // Get the <span> element that closes the modal
    $("#atlt_strings_model").find(".close").on("click", function () {
        $("#atlt_strings_model").fadeOut("slow");
    });


    function encodeHtmlEntity(str) {
        var buf = [];
        for (var i = str.length - 1; i >= 0; i--) {
            buf.unshift(['&#', str[i].charCodeAt(), ';'].join(''));
        }
        return buf.join('');
    }

    /* function encodeHtmlEntity(str) {
         return str
             .split('')
             .map(char => `&#${char.charCodeAt(0)};`)
             .join('');
     }*/

    // get object and append inside the popup
    function printStringsInPopup(jsonObj, type) {
        let html = '';
        let totalTChars = 0;
        let index = 1;

        if (jsonObj) {
            for (const key in jsonObj) {
                if (jsonObj.hasOwnProperty(key)) {
                    const element = jsonObj[key];
                    const sourceText = element.source.trim();

                    if (sourceText !== '') {
                        if ((type === "yandex") || (key <= 2500)) {
                            html += `<tr id="${key}"><td>${index}</td><td class="notranslate source">${type === "yandex" ? encodeHtmlEntity(sourceText) : sourceText}</td>`;

                            if (type === "yandex") {
                                html += `<td translate="yes" class="target translate">${sourceText}</td></tr>`;
                            } else {
                                html += '<td class="target translate"></td></tr>';
                            }

                            index++;
                            totalTChars += sourceText.length;
                        }
                    }
                }
            }
            
            $(".atlt_stats").each(function () {                
                $(this).find(".totalChars").html(totalTChars);
            });
        }

        $(".atlt_strings_table > tbody.atlt_strings_body").html(html);

    }

    function settingsModel() {
        const ytPreviewImg = ATLT_URL + 'assets/images/' + extradata['yt_preview'];
        const gtPreviewImg = ATLT_URL + 'assets/images/' + extradata['gt_preview'];
        const dplPreviewImg = ATLT_URL + 'assets/images/' + extradata['dpl_preview'];
        const chatGPTPreviewImg = ATLT_URL + 'assets/images/' + extradata['chatGPT_preview'];
        const geminiAIPreviewImg = ATLT_URL + 'assets/images/' + extradata['geminiAI_preview'];
        const getProLink = 'https://locoaddon.com/plugin/automatic-translate-addon-for-loco-translate-pro/?utm_source=atlt_plugin&utm_medium=inside&utm_campaign=get_pro&utm_content=popup_buy_pro';

        const modelHTML = `
            <div id="atlt-dialog" title="Step 1 - Select Translation Provider" style="display:none;">
                <div class="atlt-settings">
                    <strong class="atlt-heading">Translate Using Yandex Page Translate Widget</strong>
                    <div class="inputGroup">
                        <button id="atlt_yandex_translate_btn" class="notranslate button button-primary">Yandex Translate</button>
                        <span class="proonly-button alsofree">✔ Available</span>
                        <br/><a href="https://translate.yandex.com/" target="_blank"><img  class="pro-features-img" src="${ytPreviewImg}" alt="powered by Yandex Translate Widget"></a>
                    </div>
                    <hr/>
    
                    <strong class="atlt-heading">Translate Using Google Page Translate Widget</strong>
                    <div class="inputGroup">
                        <button id="atlt_gtranslate_btn" disabled="disabled" class="notranslate button button-primary">Google Translate</button>
                        <span class="proonly-button"><a href="${getProLink}" target="_blank" title="Buy Pro">PRO Only</a></span>
                        <br/><a href="https://translate.google.com/" target="_blank"><img  class="pro-features-img" src="${gtPreviewImg}" alt="powered by Google Translate Widget"></a>
                    </div>
                    <hr/>
    
                    <strong class="atlt-heading">Translate Using Deepl Doc Translator</strong>
                    <div class="inputGroup">
                        <button  disabled="disabled" id="atlt_deepl_btn" class="notranslate button button-primary">DeepL Translate</button>
                        <span class="proonly-button"><a href="${getProLink}" target="_blank" title="Buy Pro">PRO Only</a></span>
                        <br/><a href="https://www.deepl.com/en/translator" target="_blank"><img class="pro-features-img" src="${dplPreviewImg}" alt="powered by DeepL Translate"></a>
                    </div>
                    <hr/>

                    <strong class="atlt-heading">Translate Using AI</strong>
                    <div class="inputGroup">
                        <button  disabled="disabled" id="atlt_chatGPT_btn" class="notranslate button button-primary">ChatGPT Translate</button>
                        <span class="proonly-button"><a href="${getProLink}" target="_blank" title="Buy Pro">PRO Only</a></span>
                        <br/><a href="https://chat.openai.com/" target="_blank"><img class="pro-features-img" src="${chatGPTPreviewImg}" alt="powered by ChatGPT"></a>
                    </div>
                    <hr/>
    
                    <strong class="atlt-heading">Translate Using GeminiAI API</strong>
                    <div class="inputGroup">
                        <button id="atlt_openAI_btn" disabled="disabled" class="notranslate button button-primary">GeminiAI Translate</button>
                        <span class="proonly-button"><a href="${getProLink}" target="_blank" title="Buy Pro">PRO Only</a></span>
                        <br/><a href="https://gemini.google.com/" target="_blank"><img  class="pro-features-img" src="${geminiAIPreviewImg}" alt="powered by GeminiAI Translate"></a>
                    </div>
                </div>
            </div>
        `;

        $("body").append(modelHTML);
    }

    // modal to show strings
    function createStringsModal(projectId, widgetType) {
        // Set wrapper, header, and body classes based on widgetType
        let { wrapperCls, headerCls, bodyCls, footerCls } = getWidgetClasses('yandex');
        let modelHTML = `
            <div id="atlt_strings_model" class="modal atlt_custom_model  ${wrapperCls} ${rtlClass}">
                <div class="modal-content">
                    <input type="hidden" id="project_id" value="${projectId}"> 
                    ${modelHeaderHTML(widgetType, headerCls)}   
                    ${modelBodyHTML(widgetType, bodyCls)}   
                    ${modelFooterHTML(widgetType, footerCls)}   
            </div></div>`;

        $("body").append(modelHTML);
    }

    // Get widget classes based on widgetType
    function getWidgetClasses(widgetType) {
        let wrapperCls = '';
        let headerCls = '';
        let bodyCls = '';
        let footerCls = '';
        switch (widgetType) {
            case 'yandex':
                wrapperCls = 'yandex-widget-container';
                headerCls = 'yandex-widget-header';
                bodyCls = 'yandex-widget-body';
                footerCls = 'yandex-widget-footer';

                break;
            default:
                // Default class if widgetType doesn't match any case
                wrapperCls = 'yandex-widget-container';
                headerCls = 'yandex-widget-header';
                bodyCls = 'yandex-widget-body';
                footerCls = 'yandex-widget-footer';
                break;
        }
        return { wrapperCls, headerCls, bodyCls, footerCls };
    }
    function modelBodyHTML(widgetType, bodyCls) {
        const HTML = `
        <div class="modal-body  ${bodyCls}">
            <div class="atlt_translate_progress">
                Automatic translation is in progress....<br/>
                It will take a few minutes, enjoy ☕ coffee in this time!<br/><br/>
                Please do not leave this window or browser tab while the translation is in progress...
            </div>
            ${translatorWidget(widgetType)}
            <div class="atlt_string_container">
                <table class="scrolldown atlt_strings_table">
                    <thead>
                        <th class="notranslate">S.No</th>
                        <th class="notranslate">Source Text</th>
                        <th class="notranslate">Translation</th>
                    </thead>
                    <tbody class="atlt_strings_body">
                    </tbody>
                </table>
            </div>
            <div class="notice-container"></div>
        </div>`;
        return HTML;
    }


    function modelHeaderHTML(widgetType, headerCls) {
        const HTML = `
        <div class="modal-header  ${headerCls}">
                        <span class="close">&times;</span>
                        <h2 class="notranslate">Step 2 - Start Automatic Translation Process</h2>
                        <div class="atlt_actions">
                            <button class="notranslate atlt_save_strings button button-primary" disabled="true">Merge Translation</button>
                        </div>
                        <div style="display:none" class="atlt_stats hidden">
                            Wahooo! You have saved your valuable time via auto translating 
                            <strong class="totalChars"></strong> characters  using 
                            <strong>
                                <a href="https://wordpress.org/support/plugin/automatic-translator-addon-for-loco-translate/reviews/#new-post" target="_new">
                                    Loco Automatic Translate Addon
                                </a>
                            </strong>
                        </div>
                    </div>
                    <div class="notice inline notice-info is-dismissible">
                        Plugin will not translate any strings with HTML or special characters because Yandex Translator currently does not support HTML and special characters translations.
                        You can edit translated strings inside Loco Translate Editor after merging the translations. Only special characters (%s, %d) fixed at the time of merging of the translations.
                    </div>
                    <div class="notice inline notice-info is-dismissible">
                        Machine translations are not 100% correct.
                        Please verify strings before using on the production website.
                    </div>`;
        return HTML;
    }
    function modelFooterHTML(widgetType, footerCls) {
        const HTML = ` <div class="modal-footer ${footerCls}">
        <div class="atlt_actions">
            <button class="notranslate atlt_save_strings button button-primary" disabled="true">Merge Translation</button>
        </div>
        <div style="display:none" class="atlt_stats">
            Wahooo! You have saved your valuable time via auto translating 
            <strong class="totalChars"></strong> characters  using 
            <strong>
                <a href="https://wordpress.org/support/plugin/automatic-translator-addon-for-loco-translate/reviews/#new-post" target="_new">
                    Loco Automatic Translate Addon
                </a>
            </strong>
        </div>
    </div>`;
        return HTML;
    }

    // Translator widget HTML
    function translatorWidget(widgetType) {
        if (widgetType === "yandex") {
            const widgetPlaceholder = '<div id="ytWidget">..Loading</div>';
            return `
                <div class="translator-widget">
                    <h3 class="choose-lang">Choose language <span class="dashicons-before dashicons-translation"></span></h3>
                    ${widgetPlaceholder}
                </div>`;
        } else {
            return ''; // Return an empty string for non-yandex widget types
        }
    }
    // oninit
    $(document).ready(function () {
        initialize();
    });


})(window, jQuery);


