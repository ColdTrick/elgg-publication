<?php
/**
 * @package Elgg
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Roger Curry, Grid Research Centre [curry@cpsc.ucalgary.ca]
 * @author Tingxi Tan, Grid Research Centre [txtan@cpsc.ucalgary.ca]
 * @link http://grc.ucalgary.ca/
 */

return [

	// new keys
	'publications:settings:enable_bibtex' => "Aktiviere BibTex Import- und Exportfunktionen",
	'publications:forms:required' => "*",
	'publications:forms:required:hint' => "* Benötigte Felder",
	'publications:forms:required:alert' => "Bitte füllen Sie alle erforderlichen Felder aus.",
	'publications:list:pages' => "S. %s",
	'publications:list:edition' => "%s Ausg.",
	'publications:list:techreport' => "Bericht, %s",
	'publications:list:mastersthesis' => "Masters Thesis, %s",
	'publications:list:phdthesis' => "PhD Thesis, %s",
	'publications:list:inproceedings' => "Konferenzbericht der %s",
	'publications:details:attachment:download' => "Anhang laden",
	
	'publication:forms:authors' => "Autoren",
	'publications:form:author:input:info' => "Geben Sie die ersten Buchstaben eines Autors ein und wählen Sie den vorgeschlagenen Autor aus der Dropdown-Liste aus oder fügen Sie einen neuen hinzu. Eingabetaste drücken, um den Autor der Publikation hinzuzufügen.",
	
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
	'publication:exauthors' => "Zusätzliche Autoren (nicht registriert)",
	'publication:authors' => "Autoren",
	'publication:url' => "URL",
	'publication:doi' => "DOI",
	'publication:source' => "Quelle (z.B. Zeitschrift, Konferenzbeitrag, Buch, Thesis)",
	'publication:attachment' => 'Datei anhängen',
	'publication:attachment:instruction' => 'Klicken Sie auf eine Datei, um sie Ihrer Veröffentlichung anzuhängen',
	'publication:file' => 'Dateien',
	'publication:upload' => 'Dateien hochladen',
	'publication:attachment:title' => 'Datei Anhang',
	'publication:type'=>'Typ',
	'publication:source:ref' => "Quelle",
	'publication:inviteinfomsg' => "<b>%s</b> ist nicht registriert.<br/>Sende eine Einladung an <b>%s</b> um der Plattform beizutreten.",
	'publication:invitemsg'=> "Hallo %s,

ich habe Sie als Autor der Publikation '%s' auf unserem Portal hinzugefügt. Ich lade Sie ein sich auf unserer Plattform zu registrieren.

%s

",
	'publication:additionalmsg' => "\"[Text über Ihre Plattform]\"",
	'publication:volume' => "Ausgabe",
	'publication:number' => "Ausgabe Nr.",
	'publication:month'=> "Monat",
	'publication:pages' => "Anzahl Seiten",
	'publication:page_from' => "Seite von",
	'publication:page_to' => "Seite bis",
	'publication:year' => "Jahr",
	'publication:booktitle' => "Titel des Buches",
	'publication:book_editors' => "Herausgeber",
	'publication:journaltitle' => "Titel der Zeitschrift/Rezension",
	'publication:journal' => "Fachzeitschrift",
	'publication:publisher' => "Verlag",
	'publication:publish_location' => "Erscheinungsort",
	'publication:school' => "Schule",
	'publication:institution' => "Institution",
	'publication:note' => "Notiz",
	'publication:series' => "Reihe",
	'publication:address' => "Adresse",
	'publication:organization' => "Organisation",
	'publication:institution' => "Institution",
	'publication:edition' => "Ausgabe",
	'publication:type_field' => "Typ",
	'publication' => "Publikation",
	'publications' => "Publikationen",
	'publication:user' => "%s's Publikationen",
	'publication:user:friends' => "Publicationen der Kontakte von %s",
	'publication:modify' => 'Externe Autoren-Einladungen',
	'publication:your' => "Ihre Publikationen",
	
	'publication:authored:your' => "Ihre veröffentlichten Publikationen",
	'publication:catalogued:your' => "Ihre katolgisierten Publikcationen",
	'publications:catalogued' => "katlogisierte Publikationen",
	'publication:posttitle' => "%s's Publikationen: %s",
	'publication:friendsselect'=>"Wählen Sie einen Kontakt um dessen Publikationen anzuzeigen",
	'publication:friends' => "Publikationen Ihrer Kontakte",
	'publication:yourfriends' => "Letzte Publikationen Ihrer Kontakte",
	'publication:everyone' => "Alle Publikationen dieses Portals",
	'publication:new' => "Neue Publikationen",
	'publication:via' => "erstellte eine neue Publikation mit dem Titel",
	'publication:read' => "Lese eine Publikation",
	'publications:add' => "Publikation hinzufügen",
	
	'publication:add' => "Publikation hinzufügen",
	'publication:export' => "Als BibTeX-Datei exportieren",
	'publication:export:confirm:all' => "Möchten Sie alle Publikationen als BibTeX-Datei exportieren?",
	'publication:export:confirm:user' => "Möchten Sie alle Publikationen von %s als BibTeX-File exportieren?",
	'publication:export:confirm:single' => "Möchten Sie diese Publikation als BibTeX-Datei exportieren?",
	'publication:import' => "BibTeX-Datei importieren",
	'publication:bibtex' => 'BibTeX-Datei',
	'publication:bibtex:description' => 'Hier können Sie eine Bibtex-Datei hochladen, um Ihre Publikationsliste auf diese Plattform zu importieren.',
	'publication:selectimport' => 'Datei auswählen',
	'publication:group:tag' => "Eine Publikation markieren",
	'publication:saveimport' => 'Importieren',
	'publication:edit' => "Eine Publikation bearbeiten",
	'publication:abstract' => "Zusammenfassung",
	'publication:details' => "Details",
	'publication:strapline' => "%s",
	'item:object:publication' => 'Publikationen',
	'publication:never' => 'nie',
	
	'publication:draft:save' => 'Save draft',
	'publication:draft:saved' => 'Draft last saved',
	
	'publication:comments:allow' => 'Kommentare erlauben',
	'publication:bibtex:fileerror' => 'BibTex-Datei nicht gefunden',
	'publication:bibtex:blank' => 'BibTex-Datei hat keine Einträge',
	'publication:enablepublication' => 'Aktivieren Publikationen für Gruppen',
	'publication:group' => 'Gruppe Publikationen',
	'publication:search' => 'Suche Publikationen',
	'river:create:object:publication' => "%s hat eine neue Publikation mit dem Titel %s erstellt",
	'river:update:object:publication' => "%s  hat eine neue Publikation mit dem Titel %s aktualisiert",
	'publication:river:posted' => "%s schreib",
	
	'publications:widget' => "Publikationen",
	'publications:widget:description' => "Fügen Sie Ihrem Profil eine Publikationsliste hinzu",
	'publication:river:annotate' => "ein Kommentar zu dieser Publikation",
	'publication:posted' => "Ihre Publikation wurde veröffentlicht.",
	'publication:deleted' => "Ihre Publikation wurde gelöscht.",
	'publication:error' => 'Etwas ist schief gelaufen. Bitte versuche es erneut.',
	'publication:save:failure' => "Ihre Publikation konnte nicht gespeichert werden. Bitte versuchen Sie es erneut.",
	'publication:blank' => "Sie müssen Titel und benötigte Felder ausfüllen, bevor Sie diese Publikation veröffentlichen können.",
	'publication:blankauthors' => "Keine Autoren ausgewählt.",
	'publication:blankdefault' => "Bitte füllen Sie alle geforderten Felder aus.",
	'publication:type_not_supported' => "Der gewählte Publikationstyp wird nicht unterstützt",
	'publication:notfound' => "Die angegebene Publikation konnte nicht gefunden werden.",
	'publication:notdeleted' => "Diese Publikation konnte nicht gelöscht werden.",
	'publications:seeall' => "Alle Publikationen ansehen von",
	
	'publication:error:bibtext:enabled' => "BibTex-Unterstützung ist nicht aktiviert. Die Funktion, die Sie verwenden möchten, ist nicht erlaubt.",
	
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
