# Publications

[![Build Status](https://scrutinizer-ci.com/g/ColdTrick/elgg-publication/badges/build.png?b=master)](https://scrutinizer-ci.com/g/ColdTrick/elgg-publication/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/ColdTrick/elgg-publication/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/ColdTrick/elgg-publication/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/coldtrick/publications/v/stable.svg)](https://packagist.org/packages/coldtrick/publications)
[![License](https://poser.pugx.org/coldtrick/publications/license.svg)](https://packagist.org/packages/coldtrick/publications)

This plugin provides functionality for users to share their publications.

Upgraded for 1.8 by [ColdTrick IT Solutions][coldtrick_url]

## Custom publication types

It's possible to add a custom set of inputs to a publication. This can be done by eighter extending/overwriting the existing types
or by registering a new type.

### Registering a new custom type

The plugin hook `register:types`, `publications` allows you to add a new custom type. The new type will be listed on the form with the language key
`publications:type:<your new type>` if defined (otherwise it's just the new name).

### Inputs for your custom type

If you've registered a new type and the user selects it, the view `publications/publication/edit/<your new type>` will be called. 

When editing an existing publication the view gets the publication in `$vars['entity']`.

### Input validation

In the save action a plugin hook `input_validation:<your new type>`, `publications` will be triggered. If you return `false` the user 
will be send back to the add/edit form. In order to help the user with what went wrong, please use `register_error()`

### Input saving

If you name your input fields `data[somename]` this will automaticly be saved with the publication under `$entity->somename`.

If for some reason your data can't be set in this way (or you wish to manipulate the data) an event `save:data`, `publications` will be triggered
for which the third variable will contain the current publication.

### Output your data

When the publication is viewed you can add your custom data by providing a view `publications/publication/view/<your new type>`. This view needs to
output table rows in a two (2) column table.

## Todo

- Improve bibtex import/export actions
- Reenable invite functionality
- Scan language file for unused or duplicate entries
- sticky form for publication/add
- combine add and edit action into one action

## Original Credits

1. This plugin is created as part of [Geochronos][geochronos_url], a [CANARIE][canarie_url] and [Cybera Inc][cybera_url] funded Network Enabled Platform (NEP) project. 
2. This plugin reused and repurpose base code from the Blog, Invitefriends and Embed Elgg Core plugins and the BibTexParse library

[geochronos_url]: http://geochronos.org
[canarie_url]: http://canarie.ca
[cybera_url]: http://cybera.ca
[coldtrick_url]: http://www.coldtrick.com