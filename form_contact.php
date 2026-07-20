<?php
require_once 'config/database.php';
$db = getDatabaseConnection();

/**
 * Departments list 
 * 
 * Fetches all departments from the database to populate the select in the form
 */

$contact = null;
$isEdit = false;

$firstName = '';
$lastName = '';
$email = '';
$phone = '';
$jobTitle = '';
$deptId = 0;

try {

    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $id = (int)$_GET['id'];

        $sql = "SELECT * FROM contacts WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
        $contact = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($contact) {
            $isEdit = true;

            $firstName = htmlspecialchars($contact['first_name'] ?? '');
            $lastName  = htmlspecialchars($contact['last_name'] ?? '');
            $email     = htmlspecialchars($contact['email'] ?? '');
            $phone     = htmlspecialchars($contact['phone'] ?? '');
            $jobTitle  = htmlspecialchars($contact['job_title'] ?? '');
            $deptId    = (int)($contact['department_id'] ?? 0);
        }
    }

    $stmt = $db->query("SELECT id, name FROM departments ORDER BY name ASC");
    $departments = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Erreur lors de la récupération des départements : " . $e->getMessage());
}
?>

<?php require 'elements/header.php' ?>

<body>

    <div class="min-h-screen bg-stone-50">
        <main class="max-w-7xl mx-auto p-4 md:p-10">
            <header class="flex items-center space-x-4 mb-8">
                <a href="index.php" class="w-8 h-8 bg-white rounded-md flex items-center justify-center border border-stone-300 text-stone-500">
                    <i class="ph-bold ph-arrow-left text-sm"></i>
                </a>
                <div>
                    <h1 class="text-xl md:text-2xl font-medium text-stone-900"><?= $isEdit ? "Modifier le contact" : "Ajouter un contact" ?></h1>
                </div>
            </header>
            <div class="max-w-2xl mx-auto bg-white border border-stone-300 rounded-xl p-4 md:p-8">
                <form action="<?= $isEdit ? 'actions/update_contact.php' : 'actions/add_contact.php' ?>" method="POST" class="space-y-4 md:space-y-6">
                    <?php if ($isEdit): ?>
                        <input type="hidden" name="id" value="<?= $contact['id'] ?>">
                    <?php endif; ?>
                    <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-6">
                        <div class="w-full md:w-1/2">
                            <label for="first_name" class="block text-sm font-medium text-stone-700 mb-2">Prénom*</label>
                            <input type="text" id="first_name" name="first_name" required placeholder="Jane" value="<?= $firstName ?>"
                                class="w-full px-3 py-2 rounded-lg text-sm border border-stone-300 focus:outline-hidden focus:border-violet-500 focus:ring-3 focus:ring-violet-100
                                 transition duration-300 ease-in-out">
                        </div>
                        <div class="w-full md:w-1/2">
                            <label for="last_name" class="block text-sm font-medium text-stone-700 mb-2">Nom*</label>
                            <input type="text" id="last_name" name="last_name" required placeholder="Doe" value="<?= $lastName ?>"
                                class="w-full px-3 py-2 rounded-lg text-sm border border-stone-300 focus:outline-hidden focus:border-violet-500 focus:ring-3 focus:ring-violet-100
                                 transition duration-300 ease-in-out">
                        </div>
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-stone-700 mb-2">Email*</label>
                        <input type="email" id="email" name="email" required value="<?= $email ?>"
                            class="w-full px-3 py-2 rounded-lg text-sm border border-stone-300 focus:outline-hidden focus:border-violet-500 focus:ring-3 focus:ring-violet-100
                                 transition duration-300 ease-in-out"
                            placeholder="jane@workagency.com">
                    </div>

                    <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-6">
                        <div class="w-full md:w-1/2">
                            <label for="phone" class="block text-sm font-medium text-stone-700 mb-2">Numéro de téléphone</label>
                            <input type="tel" id="phone" name="phone" oninput="this.value = this.value.replace(/[^0-9+\s.-]/g, '')"
                                pattern="^(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4}$" value="<?= $phone ?>"
                                class="w-full px-3 py-2 rounded-lg text-sm border border-stone-300 focus:outline-hidden focus:border-violet-500 focus:ring-3 focus:ring-violet-100
                                 transition duration-300 ease-in-out"
                                placeholder="0612345678">
                        </div>
                        <div class="w-full md:w-1/2">
                            <label for="job_title" class="block text-sm font-medium text-stone-700 mb-2">Poste*</label>
                            <input type="text" id="job_title" name="job_title" required value="<?= $jobTitle ?>"
                                class="w-full px-3 py-2 rounded-lg text-sm border border-stone-300 focus:outline-hidden focus:border-violet-500 focus:ring-3 focus:ring-violet-100
                                 transition duration-300 ease-in-out"
                                placeholder="Développeuse Front-End">
                        </div>
                    </div>
                    <div>
                        <label for="department_id" class="block text-sm font-medium text-stone-700 mb-2">Service*</label>
                        <select id="department_id" name="department_id" required
                            class="w-full px-3 py-2 rounded-lg text-sm border border-stone-300 bg-white focus:outline-hidden focus:border-violet-500 focus:ring-3 focus:ring-violet-100 transition duration-300 ease-in-out">
                            <option value="" disabled selected>Sélectionner un service...</option>
                            <?php foreach ($departments as $dept): ?>
                                <option value="<?= $dept['id'] ?>" <?= $dept['id'] === $deptId ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($dept['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="flex items-center justify-end gap-4">
                        <a href="index.php" class="px-4 py-2.5 rounded-lg border border-stone-300 text-sm font-medium text-stone-600 hover:bg-stone-100 transition duration-300 ease-in-out">
                            Annuler
                        </a>
                        <button type="submit" class="cursor-pointer rounded-md px-4 py-2.5 bg-violet-500 text-white text-xs md:text-sm font-medium hover:bg-violet-600 transition duration-300 ease-in-out">
                            Sauvegarder
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>

</html>