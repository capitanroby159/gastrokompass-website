<?php
/**
 * config.example.php — Vorlage für die lokale Konfiguration
 *
 * EINRICHTUNG:
 *   1. Diese Datei nach config.php kopieren.
 *   2. In config.php die echten Werte eintragen.
 *   3. config.php NIEMALS committen — sie ist in .gitignore eingetragen.
 *   4. config.php zusammen mit den übrigen Dateien auf den Server hochladen
 *      (per FTP/SFTP direkt, nicht über Git).
 *
 * In Google Workspace vorher:
 *   - 2-Schritt-Verifizierung für die Absender-Adresse aktivieren
 *     (myaccount.google.com/security)
 *   - Ein "App-Passwort" erzeugen (Suche nach "App-Passwörter") — NICHT das
 *     normale Konto-Passwort verwenden, das funktioniert mit SMTP-Login
 *     nicht zuverlässig.
 */

const SMTP_USERNAME     = 'team@gastrokompass.ch';   // sendende Google-Workspace-Adresse
const SMTP_APP_PASSWORD = 'HIER_APP_PASSWORT_EINSETZEN';
const MAIL_TO           = 'team@gastrokompass.ch';   // Empfänger der Anfragen
