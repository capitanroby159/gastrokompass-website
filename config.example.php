<?php
/**
 * config.example.php — Vorlage für die lokale Konfiguration
 *
 * EINRICHTUNG:
 *   1. Diese Datei nach config.php kopieren.
 *   2. In config.php die echten Werte eintragen (siehe unten).
 *   3. config.php NIEMALS committen — sie ist in .gitignore eingetragen.
 *   4. config.php zusammen mit den übrigen Dateien auf den Server hochladen
 *      (per FTP/SFTP direkt, nicht über Git).
 *
 * SMTP-ZUGANGSDATEN FINDEN (eigenes hosttech-Postfach):
 *   Im hosttech Kundencenter unter "E-Mail" bzw. "Mail Center" das
 *   betreffende Postfach öffnen — dort werden die genauen SMTP-Angaben
 *   (Server, Port, Verschlüsselung) für dieses Postfach angezeigt. Die
 *   Werte unten sind die bei hosttech üblichen Standardwerte; falls das
 *   Kundencenter andere Angaben zeigt, diese verwenden.
 *   SMTP_USERNAME ist die volle E-Mail-Adresse des Postfachs,
 *   SMTP_PASSWORD das dazugehörige Postfach-Passwort.
 */

const SMTP_HOST        = 'mail.gastrokompass.ch'; // ggf. im hosttech Mail Center prüfen
const SMTP_PORT        = 465;                     // 465 = SSL/TLS
const SMTP_ENCRYPTION  = 'ssl';                   // 'ssl' für Port 465, 'tls' für Port 587
const SMTP_USERNAME    = 'team@gastrokompass.ch'; // sendendes Postfach
const SMTP_PASSWORD    = 'HIER_POSTFACH_PASSWORT_EINSETZEN';
const MAIL_TO          = 'team@gastrokompass.ch'; // Empfänger der Anfragen
const MAIL_FROM_NAME   = 'gastrokompass Website';
