<?php
// ControllerSupprimer_ticket.php
// Permet de supprimer un ticket et de rediriger vers la liste des tickets
require_once __DIR__ . '/../Model/ModelDetails_ticket.php';

// Sécurisation du droit d'accès (seuls les admins ont le droit)
if (!($_SESSION['is_admin'] ?? false)) {
    die("Accès refusé. Vous devez être administrateur pour supprimer un ticket.");
}

// Récupération du numéro de ticket depuis l'URL
$num_ticket = $_GET['ticket'] ?? '';

if (!empty($num_ticket)) {
    $succes = supprimer_ticket_par_numero($num_ticket);

    if ($succes) {
        // Enregistrement du message de confirmation en session
        $_SESSION['flash_message'] = "Le ticket <strong>" . htmlspecialchars($num_ticket) . "</strong> a été supprimé avec succès, ainsi que toutes ses réponses et pièces jointes.";
        $_SESSION['flash_type'] = "success"; // Pour afficher le bandeau en vert
    } else {
        $_SESSION['flash_message'] = "Une erreur est survenue lors de la suppression du ticket.";
        $_SESSION['flash_type'] = "error"; // Pour afficher le bandeau en rouge
    }
}

// Redirection vers la page admin 
header("Location: index.php?page=admin_tickets");
exit();
