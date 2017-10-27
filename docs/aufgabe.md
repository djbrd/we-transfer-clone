---
title: '[]{#_9nvgf834dfwb .anchor}Developer Task'
---

Mission
=======

Implementierung eines einfachen **WeTransfer** Klons.

Use-Cases / Akzeptanzkriterien
------------------------------

Als Nutzer (Sharer) kann ich eine Webseite mit Upload-Formular und einem
Passworteingabefeld aufrufen um das Teilen einer Datei vorzubereiten.

Als Nutzer (Sharer) wähle ich über das Upload-Formular eine lokale Datei
von meinem Rechner, gebe ein Passwort ein und klicke dann "Teilen", um
nach dem Upload auf einer folgenden Seite eine kurze URL (Share-URL) zum
Download der Datei zu sehen. Ein Teil der Share-URL besteht aus einem
alphanumerischen Code, der vom System generiert wird.

Als Nutzer (Downloader) gebe ich eine Share-URL in den Browser ein und
sehe ein Formular zur Passwortabfrage um den Download zu starten.
Weiteres Akzeptanzkriterium: Bei einer unbekannten URL erscheint eine
entsprechende Meldung statt der Passwortabfrage.

Als Nutzer (Downloader) gebe ich ein korrektes Passwort in das Download
Formular ein, klicke auf "downloaden" um den Download der Datei im
Browser zu starten. Weiteres Akzeptanzkriterium: Bei einem fehlerhaften
Passwort erscheint eine entsprechende Meldung.

Zu verwendende Technologien
---------------------------

-   PHP / Composer

-   File-Upload via Filestack Filepicker\
    > https://www.filestack.com/ - Demo Account nutzen!

-   MySQL

Dies sind lediglich *Mindestanforderungen* - weitere Tools / Systeme
gerne nach Bedarf wählen!

Weitere Randbedingungen / Hinweise
----------------------------------

-   Einhaltung von Standards

-   Pragmatische Ansätze / KISS

-   Ggf. "Known Problems" oder Verbesserungsmöglichkeiten der Lösung

-   Lösungsweg / -ansatz bitte kommentieren
