<?php
/**
 * send-mail.php
 * Kontaktformular-Handler für gastrokompass.ch — Versand über Google Workspace (SMTP)
 *
 * EINRICHTUNG (vor dem Hochladen ausfüllen):
 *   1. In Google Workspace: 2-Schritt-Verifizierung für die Absender-Adresse aktivieren
 *      (myaccount.google.com/security)
 *   2. Dort ein "App-Passwort" erzeugen (Suche nach "App-Passwörter") — NICHT das normale
 *      Konto-Passwort verwenden, das funktioniert mit SMTP-Login nicht zuverlässig.
 *   3. Unten bei SMTP_USERNAME die sendende Adresse eintragen, bei SMTP_APP_PASSWORD
 *      das erzeugte App-Passwort (16-stellig, ohne Leerzeichen).
 *   4. Diese Datei + den Ordner lib/phpmailer/ zusammen mit index.html auf hosttech hochladen.
 *
 * WICHTIG: Diese Datei enthält nach dem Ausfüllen ein Passwort im Klartext.
 * Nicht öffentlich teilen, nicht in ein öffentliches Git-Repo committen.
 */

// ---- Konfiguration ----------------------------------------------------
const SMTP_USERNAME     = 'team@gastrokompass.ch';   // sendende Google-Workspace-Adresse
const SMTP_APP_PASSWORD = 'HIER_APP_PASSWORT_EINSETZEN';
const MAIL_TO           = 'team@gastrokompass.ch';   // Empfänger der Anfragen
// -------------------------------------------------------------------------

require __DIR__ . '/lib/phpmailer/Exception.php';
require __DIR__ . '/lib/phpmailer/PHPMailer.php';
require __DIR__ . '/lib/phpmailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.html');
    exit;
}

// Honeypot: Bots füllen unsichtbare Felder aus, Menschen nicht.
if (!empty($_POST['website'])) {
    exit;
}

// Eingaben bereinigen — nur Steuerzeichen/Zeilenumbrüche entfernen,
// KEIN htmlspecialchars hier: Der Text geht in eine reine Text-E-Mail,
// nicht in HTML — sonst erscheinen "&amp;" & Co. wörtlich in der Mail.
function clean_field($value) {
    $value = trim($value ?? '');
    return preg_replace('/[\r\n]+/', ' ', $value);
}

$name    = clean_field($_POST['name'] ?? '');
$email   = clean_field($_POST['email'] ?? '');
$betrieb = clean_field($_POST['betrieb'] ?? '');
$telefon = clean_field($_POST['telefon'] ?? '');
$message = trim($_POST['message'] ?? ''); // Zeilenumbrüche hier bewusst erhalten

// Validierung
$errors = [];
if ($name === '') {
    $errors[] = 'Name fehlt';
}
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Gültige E-Mail-Adresse fehlt';
}
if ($message === '') {
    $errors[] = 'Nachricht fehlt';
}

if (!empty($errors)) {
    http_response_code(400);
    echo 'Es gab ein Problem mit Ihrer Eingabe: ' . htmlspecialchars(implode(', ', $errors), ENT_QUOTES, 'UTF-8') . '. ';
    echo 'Bitte gehen Sie zurück und prüfen Sie das Formular.';
    exit;
}

// E-Mail-Inhalt zusammenstellen
$subject = 'Neue Kontaktanfrage über die Website – ' . $name;
$body  = "Neue Anfrage über das Kontaktformular auf gastrokompass.ch\n\n";
$body .= "Name:    $name\n";
$body .= "E-Mail:  $email\n";
$body .= "Betrieb: " . ($betrieb !== '' ? $betrieb : '–') . "\n";
$body .= "Telefon: " . ($telefon !== '' ? $telefon : '–') . "\n\n";
$body .= "Nachricht:\n$message\n";

$mail = new PHPMailer(true);

try {
    // SMTP-Verbindung über Google Workspace
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = SMTP_USERNAME;
    $mail->Password   = SMTP_APP_PASSWORD;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;
    $mail->CharSet    = 'UTF-8';

    $mail->setFrom(SMTP_USERNAME, 'gastrokompass Website');
    $mail->addAddress(MAIL_TO);
    $mail->addReplyTo($email, $name); // Antworten gehen direkt an den Absender

    $mail->isHTML(false);
    $mail->Subject = $subject;
    $mail->Body    = $body;

    $mail->send();

    header('Location: index.html?kontakt=erfolg#termin');
    exit;
} catch (Exception $e) {
    http_response_code(500);
    echo 'Die Nachricht konnte leider nicht gesendet werden. ';
    echo 'Bitte versuchen Sie es später erneut oder schreiben Sie direkt an team@gastrokompass.ch.';
    // Für die Fehlersuche während der Einrichtung (danach gerne entfernen):
    // echo '<!-- ' . htmlspecialchars($mail->ErrorInfo, ENT_QUOTES, 'UTF-8') . ' -->';
    exit;
}
