<template>
    <div class="form-group">
        <label for="algolia-ticket">{{ name }}</label>
        <textarea class="form-control" :placeholder="name" required="required" :name="attribute" rows="2" id="algolia-ticket"></textarea>
    </div>
</template>

<script>
    export default {
        props: ['attribute', 'name'],
        mounted() {
            let algoliasearch = require('algoliasearch');
            let autocomplete = require('autocomplete.js');

            let client = algoliasearch('W5YBJG8EID', 'd04b8d393d0d1c4df71c8a6c55d3d7d0');
            let index = client.initIndex('tickets');

            autocomplete('#algolia-ticket', {hint: false}, { //debug: true
                source: autocomplete.sources.hits(index, {hitsPerPage: 75}),
                displayKey: 'text',
                templates: {
                    suggestion: function (suggestion) {
                        return suggestion._highlightResult.text.value;
                    }
                }
            });
        }
    }
</script>

<style>
    .algolia-autocomplete {
        width: 100%;
    }

    .algolia-autocomplete .aa-input,
    .algolia-autocomplete .aa-hint {
        width: 100%;
    }

    .algolia-autocomplete .aa-hint {
        color: #999;
    }

    .algolia-autocomplete .aa-dropdown-menu {
        width: 100%;
        background-color: #fff;
        border: 1px solid #999;
        border-top: none;
    }

    .algolia-autocomplete .aa-dropdown-menu .aa-suggestion {
        cursor: pointer;
        padding: 5px 4px;
    }

    .algolia-autocomplete .aa-dropdown-menu .aa-suggestion.aa-cursor {
        background-color: #B2D7FF;
    }

    .algolia-autocomplete .aa-dropdown-menu .aa-suggestions {
        height: 200px;
        overflow: auto;
    }

    .algolia-autocomplete .aa-dropdown-menu .aa-suggestion em {
        font-weight: 700;
        font-style: normal;
    }
</style>