<?php
/**
 * @package Elgg
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Roger Curry, Grid Research Centre [curry@cpsc.ucalgary.ca]
 * @author Tingxi Tan, Grid Research Centre [txtan@cpsc.ucalgary.ca]
 * @link http://grc.ucalgary.ca/
 */

return [

	'publications' => "Publikationen",
	'item:object:publication' => 'Publikationen',
	'river:create:object:publication' => "%s erstellte eine neue Publikation mit dem Titel %s",
	'river:update:object:publication' => "%s aktualisierte eine Publikation mit dem Titel %s",

	// new keys
	'publications:settings:enable_bibtex' => "Aktiviere BibTeX Import- und Exportfunktionen",
	'publications:forms:required' => "*",
	'publications:forms:required:hint' => "* Benötigte Felder",
	'publications:forms:required:alert' => "Bitte füllen Sie alle erforderlichen Felder aus.",
	'publications:details:attachment:download' => "Anhang laden",

	'publication:forms:authors' => "Autoren",
	'publications:form:author:input:info' => "Geben Sie die ersten Buchstaben eines Autors ein und wählen Sie den vorgeschlagenen Autor aus der Dropdown-Liste aus oder fügen Sie einen neuen hinzu. Eingabetaste drücken, um den Autor der Publikation hinzuzufügen.",

	'publications:menu:filter:mine' => "Meine",
	'publications:menu:filter:author' => "Verfasst",

	'publications:select:all' => 'Zeige alle',
	'publications:select:owned' => 'Publikationen, die ich hochgeladen habe',
	'publications:select:assigned' => 'Publikationen, denen ich als Autor zugeordnet bin',

	'publications:add' => "Publikation hinzufügen",
	
	// types
	'publications:type:article' => "Zeitungs- oder Zeitschriftenartikel",
	'publications:type:book' => "Buch",
	'publications:type:booklet' => "Gebundenes Druckwerk",
	'publications:type:conference' => "Wissenschaftliche Konferenz",
	'publications:type:inbook' => "Teil eines Buches",
	'publications:type:incollection' => "Teil eines Buches mit einem eigenen Titel",
	'publications:type:inproceedings' => "Artikel in einem Konferenzbericht",
	'publications:type:manual' => "Technische Dokumentation",
	'publications:type:mastersthesis' => "Diplom-, Magister- oder andere Abschlussarbeit (außer Promotion)",
	'publications:type:phdthesis' => "Doktor- oder andere Promotionsarbeit",
	'publications:type:proceedings' => "Konferenzbericht",
	'publications:type:techreport' => "Veröffentlichter Bericht einer Hochschule oder anderen Institution",
	'publications:type:unpublished' => "Nicht formell veröffentlichtes Dokument",
	
	// old keys
	'publication:keywords' => "Schlagworte",
	'publication:keywords:instruction' => "",
	'publication:authors' => "Autoren",
	'publication:attachment' => 'Datei anhängen',
	'publication:attachment:instruction' => 'Klicken Sie auf eine Datei, um sie Ihrer Veröffentlichung anzuhängen',
	'publication:attachment:title' => 'Datei Anhang',
	'publication:type'=>'Typ',
	'publication:inviteinfomsg' => "<b>%s</b> ist nicht registriert.<br/>Sende eine Einladung an <b>%s</b> um der Plattform beizutreten.",
	'publication:invitemsg'=> "Hallo %s,

ich habe Sie als Autor der Publikation '%s' auf unserem Portal hinzugefügt. Ich lade Sie ein sich auf unserer Plattform zu registrieren.

%s

",
	'publication:additionalmsg' => "\"[Text über Ihre Plattform]\"",
	'publication:volume' => "Ausgabe",
	'publication:number' => "Ausgabe Nr.",
	'publication:month'=> "Monat",
	'publication:page_from' => "Seite von",
	'publication:page_to' => "Seite bis",
	'publication:year' => "Jahr",
	'publication:booktitle' => "Titel des Buches",
	'publication:book_editors' => "Herausgeber",
	'publication:journaltitle' => "Titel der Zeitschrift/Rezension",
	'publication:publisher' => "Verlag",
	'publication:publish_location' => "Erscheinungsort",
	'publication:school' => "Schule",
	'publication:institution' => "Institution",
	'publication:series' => "Reihe",
	'publication:organization' => "Organisation",
	'publication:institution' => "Institution",
	'publication:edition' => "Ausgabe",
	'publication:user' => "Publikationen von %s",
	'publication:friends' => "Publikationen meiner Freunde",
	'publication:user:author' => "%s's verfasste Publikationen",
	'publication:modify' => 'Externe Autoren-Einladungen',
	'publication:everyone' => "Alle Publikationen dieses Portals",
	'publication:export' => "Als BibTeX-Datei exportieren",
	'publication:export:confirm:all' => "Möchten Sie alle Publikationen als BibTeX-Datei exportieren?",
	'publication:export:confirm:user' => "Möchten Sie alle Publikationen von %s als BibTeX-File exportieren?",
	'publication:export:confirm:single' => "Möchten Sie diese Publikation als BibTeX-Datei exportieren?",
	'publication:import' => "BibTeX-Datei importieren",
	'publication:bibtex' => 'BibTeX-Datei',
	'publication:bibtex:description' => 'Hier können Sie eine BibTeX-Datei hochladen, um Ihre Publikationsliste auf diese Plattform zu importieren.',
	'publication:edit' => "Eine Publikation bearbeiten",
	'publication:abstract' => "Zusammenfassung",
	'publication:details' => "Details",
	'publication:bibtex:fileerror' => 'BibTeX-Datei nicht gefunden',
	'publication:bibtex:blank' => 'BibTeX-Datei hat keine Einträge',
	'publication:enablepublication' => 'Aktivieren Publikationen für Gruppen',
	'publication:group' => 'Gruppe Publikationen',
	'publication:river:posted' => "%s schreib",	
	'publications:widget' => "Publikationen",
	'publications:widget:description' => "Fügen Sie Ihrem Profil eine Publikationsliste hinzu",
	'publication:posted' => "Ihre Publikation wurde veröffentlicht.",
	'publication:deleted' => "Ihre Publikation wurde gelöscht.",
	'publication:error' => 'Etwas ist schief gelaufen. Bitte versuche es erneut.',
	'publication:blank' => "Sie müssen Titel und benötigte Felder ausfüllen, bevor Sie diese Publikation veröffentlichen können.",
	'publication:blankdefault' => "Bitte füllen Sie alle geforderten Felder aus.",
	'publication:type_not_supported' => "Der gewählte Publikationstyp wird nicht unterstützt",
	'publication:notdeleted' => "Diese Publikation konnte nicht gelöscht werden.",
	'publications:seeall' => "Alle Publikationen ansehen von",
	
	'publication:error:bibtext:enabled' => "BibTeX-Unterstützung ist nicht aktiviert. Die Funktion, die Sie verwenden möchten, ist nicht erlaubt.",
	
	// notifications
	'publication:notification:create:subject' => "Eine neue Publikation \"%s\" wurde veröffentlicht",
	'publication:notification:create:summary' => "Neue Publikation \"%s\"",
	'publication:notification:create:body' => "Hallo,

%s erstellte eine neue Publikation \"%s\".

Um die Publikation anzuzeigen, klicken Sie auf den folgenden Link:
%s",
	
	'publication:import:forward' => "Nach dem Hochladen die Bearbeitungsseite anzeigen",
	'publication:import:forward:description' => "Funktioniert nur, wenn eine einzelne Publikation importiert wurde.",
	
	'publication:action:import:error:none' => "Es wurden keine Publikationen importiert",
	'publication:action:import:success:single' => "Die Publikation(en) wurden importiert",
	'publication:action:import:success:multiple_duplicates' => "%s Publikationen importiert, %s Publikationen bereits auf der Plattform vorhanden",
	'publication:action:import:success:multiple' => "%s Publikationen importiert",
	'publication:action:import:success:duplicates' => "Keine Publikationen importiert, %s Publikationen bereits auf der Plattform vorhanden",
];
