<?php

/**
 * Contacts list
 * 
 * Fetches all contacts from the database with their associated department
 */

require_once 'config/database.php';
$db = getDatabaseConnection();

try {
    $query = "SELECT contacts.*, departments.name AS department_name, departments.color AS department_color 
              FROM contacts 
              LEFT JOIN departments ON contacts.department_id = departments.id 
              ORDER BY contacts.created_at DESC";

    $stmt = $db->query($query);
    $contacts = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Erreur lors de la récupération des contacts : " . $e->getMessage());
}
?>
<?php require 'elements/header.php' ?>

<body>
    <div class="min-h-screen bg-stone-50">
        <main class="max-w-7xl mx-auto p-4 md:p-10">
            <header class="flex items-center justify-between mb-8">
                <h1 class="text-xl md:text-2xl font-medium text-stone-900">Mes contacts</h1>
                <a href="form_contact.php" class="self-end w-fit rounded-md px-4 py-2 bg-violet-500 text-white text-xs md:text-sm font-medium hover:bg-violet-600 transition duration-300 ease-in-out">Ajouter un contact</a>
            </header>
            <section>
                <?php if (empty($contacts)): ?>
                    <div class="bg-stone-100 border border-stone-300 text-stone-600 rounded-xl px-4 py-2 w-fit mx-auto">
                        <p>Aucun contact trouvé. Cliquez sur "Ajouter un contact" pour commencer !</p>
                    </div>
                <?php else: ?>
                    <div class="relative flex flex-col w-full h-full text-stone-600 bg-white rounded-xl border border-stone-300 overflow-x-auto">
                        <table class="text-sm w-full text-left table-auto min-w-max">
                            <thead>
                                <tr class="text-sm text-stone-600">
                                    <th class="font-medium px-4 py-3 border-b border-r border-stone-200 bg-stone-100">Nom</th>
                                    <th class="font-medium px-4 py-3 border-b border-r border-stone-200 bg-stone-100">Poste</th>
                                    <th class="font-medium px-4 py-3 border-b border-r border-stone-200 bg-stone-100">Service</th>
                                    <th class="font-medium px-4 py-3 border-b border-r border-stone-200 bg-stone-100">Numéro de téléphone</th>
                                    <th class="font-medium px-4 py-3 border-b border-r border-stone-200 bg-stone-100">Email</th>
                                    <th class="font-medium px-4 py-3 border-b border-stone-200 bg-stone-100"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($contacts as $contact): ?>
                                    <tr class="[&:not(:last-child)]:border-b border-stone-200 bg-white hover:bg-stone-100 transition duration-150 ease-in-out">
                                        <td class="flex space-x-3 items-center py-2 px-4 border-r border-stone-200">
                                            <div class="bg-violet-100 text-violet-500 font-medium rounded-full w-8 h-8 text-sm flex justify-center items-center">
                                                <?= strtoupper(substr($contact['first_name'], 0, 1) . substr($contact['last_name'], 0, 1)) ?>
                                            </div>
                                            <span class="text-sm text-stone-900">
                                                <?= htmlspecialchars($contact['first_name']) ?> <?= htmlspecialchars($contact['last_name']) ?>
                                            </span>
                                        </td>
                                        <td class="py-2 px-4 border-r border-stone-200 text-stone-500">
                                            <span class=""><?= htmlspecialchars($contact['job_title']) ?></span>
                                        </td>
                                        <td class="py-2 px-4 border-r border-stone-200 text-stone-500">
                                            <?php if ($contact['department_name']): ?>
                                                <span class="rounded px-2 py-1 text-xs font-medium" style="background-color: <?= $contact['department_color'] ?>1a; color: <?= $contact['department_color'] ?>;">
                                                    <?= htmlspecialchars($contact['department_name']) ?>
                                                </span>
                                            <?php else: ?>
                                                <span class="badge badge-default">Aucun</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="py-2 px-4 border-r border-stone-200 text-stone-500"><?= htmlspecialchars($contact['phone'] ?? '') ?></td>
                                        <td class="py-2 px-4 border-r border-stone-200 text-stone-500"><?= htmlspecialchars($contact['email']) ?></td>
                                        <td class="py-2 px-4 flex justify-between items-center">
                                            <a href="form_contact.php?id=<?= $contact['id'] ?>" class="text-neutral-600 hover:text-neutral-800 transition duration-150 ease-in-out">
                                                <i class="ph-duotone ph-pencil text-lg"></i></a>
                                            <a href="actions/delete_contact.php?id=<?= $contact['id'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce contact ?')" class="text-red-500 hover:text-red-600 transition duration-150 ease-in-out">
                                                <i class="ph-duotone ph-trash text-lg"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </section>
        </main>
    </div>
</body>

</html>