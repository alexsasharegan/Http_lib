
(function(root) {

    var bhIndex = null;
    var rootPath = '';
    var treeHtml = '        <ul>                <li data-name="namespace:Http" class="opened">                    <div style="padding-left:0px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Http.html">Http</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="namespace:Http_Exceptions" class="opened">                    <div style="padding-left:18px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Http/Exceptions.html">Exceptions</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Http_Exceptions_InvalidStatusCode" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Http/Exceptions/InvalidStatusCode.html">InvalidStatusCode</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="class:Http_Http" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="Http/Http.html">Http</a>                    </div>                </li>                            <li data-name="class:Http_Request" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="Http/Request.html">Request</a>                    </div>                </li>                            <li data-name="class:Http_Response" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="Http/Response.html">Response</a>                    </div>                </li>                </ul></div>                </li>                </ul>';

    var searchTypeClasses = {
        'Namespace': 'label-default',
        'Class': 'label-info',
        'Interface': 'label-primary',
        'Trait': 'label-success',
        'Method': 'label-danger',
        '_': 'label-warning'
    };

    var searchIndex = [
                    
            {"type": "Namespace", "link": "Http.html", "name": "Http", "doc": "Namespace Http"},{"type": "Namespace", "link": "Http/Exceptions.html", "name": "Http\\Exceptions", "doc": "Namespace Http\\Exceptions"},
            
            {"type": "Class", "fromName": "Http\\Exceptions", "fromLink": "Http/Exceptions.html", "link": "Http/Exceptions/InvalidStatusCode.html", "name": "Http\\Exceptions\\InvalidStatusCode", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "Http\\Exceptions\\InvalidStatusCode", "fromLink": "Http/Exceptions/InvalidStatusCode.html", "link": "Http/Exceptions/InvalidStatusCode.html#method___construct", "name": "Http\\Exceptions\\InvalidStatusCode::__construct", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Http\\Exceptions\\InvalidStatusCode", "fromLink": "Http/Exceptions/InvalidStatusCode.html", "link": "Http/Exceptions/InvalidStatusCode.html#method___toString", "name": "Http\\Exceptions\\InvalidStatusCode::__toString", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Http\\Exceptions\\InvalidStatusCode", "fromLink": "Http/Exceptions/InvalidStatusCode.html", "link": "Http/Exceptions/InvalidStatusCode.html#method_jsonSerialize", "name": "Http\\Exceptions\\InvalidStatusCode::jsonSerialize", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "Http", "fromLink": "Http.html", "link": "Http/Http.html", "name": "Http\\Http", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "Http\\Http", "fromLink": "Http/Http.html", "link": "Http/Http.html#method_redirect", "name": "Http\\Http::redirect", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Http\\Http", "fromLink": "Http/Http.html", "link": "Http/Http.html#method_status", "name": "Http\\Http::status", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Http\\Http", "fromLink": "Http/Http.html", "link": "Http/Http.html#method___construct", "name": "Http\\Http::__construct", "doc": "&quot;Http constructor.&quot;"},
                    {"type": "Method", "fromName": "Http\\Http", "fromLink": "Http/Http.html", "link": "Http/Http.html#method_get", "name": "Http\\Http::get", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Http\\Http", "fromLink": "Http/Http.html", "link": "Http/Http.html#method_post", "name": "Http\\Http::post", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Http\\Http", "fromLink": "Http/Http.html", "link": "Http/Http.html#method_put", "name": "Http\\Http::put", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Http\\Http", "fromLink": "Http/Http.html", "link": "Http/Http.html#method_patch", "name": "Http\\Http::patch", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Http\\Http", "fromLink": "Http/Http.html", "link": "Http/Http.html#method_delete", "name": "Http\\Http::delete", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Http\\Http", "fromLink": "Http/Http.html", "link": "Http/Http.html#method_error", "name": "Http\\Http::error", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Http\\Http", "fromLink": "Http/Http.html", "link": "Http/Http.html#method_exec", "name": "Http\\Http::exec", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Http\\Http", "fromLink": "Http/Http.html", "link": "Http/Http.html#method_send", "name": "Http\\Http::send", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Http\\Http", "fromLink": "Http/Http.html", "link": "Http/Http.html#method_handleError", "name": "Http\\Http::handleError", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Http\\Http", "fromLink": "Http/Http.html", "link": "Http/Http.html#method_abort", "name": "Http\\Http::abort", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Http\\Http", "fromLink": "Http/Http.html", "link": "Http/Http.html#method___toString", "name": "Http\\Http::__toString", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "Http", "fromLink": "Http.html", "link": "Http/Request.html", "name": "Http\\Request", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "Http\\Request", "fromLink": "Http/Request.html", "link": "Http/Request.html#method___construct", "name": "Http\\Request::__construct", "doc": "&quot;Request constructor.&quot;"},
                    {"type": "Method", "fromName": "Http\\Request", "fromLink": "Http/Request.html", "link": "Http/Request.html#method_get", "name": "Http\\Request::get", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Http\\Request", "fromLink": "Http/Request.html", "link": "Http/Request.html#method_query", "name": "Http\\Request::query", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Http\\Request", "fromLink": "Http/Request.html", "link": "Http/Request.html#method___toString", "name": "Http\\Request::__toString", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "Http", "fromLink": "Http.html", "link": "Http/Response.html", "name": "Http\\Response", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "Http\\Response", "fromLink": "Http/Response.html", "link": "Http/Response.html#method___construct", "name": "Http\\Response::__construct", "doc": "&quot;Response constructor.&quot;"},
                    {"type": "Method", "fromName": "Http\\Response", "fromLink": "Http/Response.html", "link": "Http/Response.html#method_get", "name": "Http\\Response::get", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Http\\Response", "fromLink": "Http/Response.html", "link": "Http/Response.html#method_set", "name": "Http\\Response::set", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Http\\Response", "fromLink": "Http/Response.html", "link": "Http/Response.html#method_set_array", "name": "Http\\Response::set_array", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Http\\Response", "fromLink": "Http/Response.html", "link": "Http/Response.html#method_push", "name": "Http\\Response::push", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Http\\Response", "fromLink": "Http/Response.html", "link": "Http/Response.html#method_unshift", "name": "Http\\Response::unshift", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Http\\Response", "fromLink": "Http/Response.html", "link": "Http/Response.html#method_header", "name": "Http\\Response::header", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Http\\Response", "fromLink": "Http/Response.html", "link": "Http/Response.html#method___toString", "name": "Http\\Response::__toString", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Http\\Response", "fromLink": "Http/Response.html", "link": "Http/Response.html#method_jsonSerialize", "name": "Http\\Response::jsonSerialize", "doc": "&quot;&quot;"},
            
            
                                        // Fix trailing commas in the index
        {}
    ];

    /** Tokenizes strings by namespaces and functions */
    function tokenizer(term) {
        if (!term) {
            return [];
        }

        var tokens = [term];
        var meth = term.indexOf('::');

        // Split tokens into methods if "::" is found.
        if (meth > -1) {
            tokens.push(term.substr(meth + 2));
            term = term.substr(0, meth - 2);
        }

        // Split by namespace or fake namespace.
        if (term.indexOf('\\') > -1) {
            tokens = tokens.concat(term.split('\\'));
        } else if (term.indexOf('_') > 0) {
            tokens = tokens.concat(term.split('_'));
        }

        // Merge in splitting the string by case and return
        tokens = tokens.concat(term.match(/(([A-Z]?[^A-Z]*)|([a-z]?[^a-z]*))/g).slice(0,-1));

        return tokens;
    };

    root.Sami = {
        /**
         * Cleans the provided term. If no term is provided, then one is
         * grabbed from the query string "search" parameter.
         */
        cleanSearchTerm: function(term) {
            // Grab from the query string
            if (typeof term === 'undefined') {
                var name = 'search';
                var regex = new RegExp("[\\?&]" + name + "=([^&#]*)");
                var results = regex.exec(location.search);
                if (results === null) {
                    return null;
                }
                term = decodeURIComponent(results[1].replace(/\+/g, " "));
            }

            return term.replace(/<(?:.|\n)*?>/gm, '');
        },

        /** Searches through the index for a given term */
        search: function(term) {
            // Create a new search index if needed
            if (!bhIndex) {
                bhIndex = new Bloodhound({
                    limit: 500,
                    local: searchIndex,
                    datumTokenizer: function (d) {
                        return tokenizer(d.name);
                    },
                    queryTokenizer: Bloodhound.tokenizers.whitespace
                });
                bhIndex.initialize();
            }

            results = [];
            bhIndex.get(term, function(matches) {
                results = matches;
            });

            if (!rootPath) {
                return results;
            }

            // Fix the element links based on the current page depth.
            return $.map(results, function(ele) {
                if (ele.link.indexOf('..') > -1) {
                    return ele;
                }
                ele.link = rootPath + ele.link;
                if (ele.fromLink) {
                    ele.fromLink = rootPath + ele.fromLink;
                }
                return ele;
            });
        },

        /** Get a search class for a specific type */
        getSearchClass: function(type) {
            return searchTypeClasses[type] || searchTypeClasses['_'];
        },

        /** Add the left-nav tree to the site */
        injectApiTree: function(ele) {
            ele.html(treeHtml);
        }
    };

    $(function() {
        // Modify the HTML to work correctly based on the current depth
        rootPath = $('body').attr('data-root-path');
        treeHtml = treeHtml.replace(/href="/g, 'href="' + rootPath);
        Sami.injectApiTree($('#api-tree'));
    });

    return root.Sami;
})(window);

$(function() {

    // Enable the version switcher
    $('#version-switcher').change(function() {
        window.location = $(this).val()
    });

    
        // Toggle left-nav divs on click
        $('#api-tree .hd span').click(function() {
            $(this).parent().parent().toggleClass('opened');
        });

        // Expand the parent namespaces of the current page.
        var expected = $('body').attr('data-name');

        if (expected) {
            // Open the currently selected node and its parents.
            var container = $('#api-tree');
            var node = $('#api-tree li[data-name="' + expected + '"]');
            // Node might not be found when simulating namespaces
            if (node.length > 0) {
                node.addClass('active').addClass('opened');
                node.parents('li').addClass('opened');
                var scrollPos = node.offset().top - container.offset().top + container.scrollTop();
                // Position the item nearer to the top of the screen.
                scrollPos -= 200;
                container.scrollTop(scrollPos);
            }
        }

    
    
        var form = $('#search-form .typeahead');
        form.typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        }, {
            name: 'search',
            displayKey: 'name',
            source: function (q, cb) {
                cb(Sami.search(q));
            }
        });

        // The selection is direct-linked when the user selects a suggestion.
        form.on('typeahead:selected', function(e, suggestion) {
            window.location = suggestion.link;
        });

        // The form is submitted when the user hits enter.
        form.keypress(function (e) {
            if (e.which == 13) {
                $('#search-form').submit();
                return true;
            }
        });

    
});


