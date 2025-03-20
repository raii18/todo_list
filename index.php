<!DOCTYPE html>
<html>
<head>
    <title>todo_list </title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <h2>🎀 TO DO LIST</h2>
    <ul class="nav">
        <li onclick="filterTasks('all')"><i class="fas fa-list"></i><span> All Tasks</span></li>
        <li onclick="filterTasks('completed')"><i class="fas fa-check-circle"></i><span> Completed</span></li>
        <li onclick="filterTasks('pending')"><i class="fas fa-hourglass-half"></i><span> Pending</span></li>
        <li onclick="toggleSidebar()"><i class="fas fa-bars"></i><span> Collapse</span></li>
    </ul>
</div>

<!-- Main Content -->
<div class="main-content">
    <button class="toggle-btn">🌙 Dark Mode</button>
    
    <div class="container">
        <h1> Manage Your Tasks</h1>

        <form action="add_task.php" method="POST">
            <input type="text" name="task_name" placeholder="Enter a task..." required>
            <button type="submit">Add Task</button>
        </form>

        <ul class="task-list">
            <?php
            include 'db.php';
            $stmt = $conn->query("SELECT * FROM tasks ORDER BY created_at DESC");
            $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>

            <?php foreach ($tasks as $task): ?>
                <li class="<?= $task['is_completed'] ? 'completed' : '' ?>" data-status="<?= $task['is_completed'] ? 'completed' : 'pending' ?>">
                    <?= htmlspecialchars($task['task_name']) ?>
                    <div class="actions">
                        <?php if (!$task['is_completed']): ?>
                            <a href="complete_task.php?id=<?= $task['id'] ?>" class="complete">Complete</a>
                        <?php endif; ?>
                        <a href="delete_task.php?id=<?= $task['id'] ?>" class="delete">Delete</a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

<!-- JavaScript -->
<script>
   
    const toggleBtn = document.querySelector('.toggle-btn');
    toggleBtn.addEventListener('click', () => {
        document.body.classList.toggle('dark-mode');
        if (document.body.classList.contains('dark-mode')) {
            localStorage.setItem('theme', 'dark');
        } else {
            localStorage.setItem('theme', 'light');
        }
    });

   
    document.addEventListener('DOMContentLoaded', () => {
        if (localStorage.getItem('theme') === 'dark') {
            document.body.classList.add('dark-mode');
        }
    });

    
    function filterTasks(status) {
        const tasks = document.querySelectorAll('.task-list li');
        tasks.forEach(task => {
            if (status === 'all' || task.dataset.status === status) {
                task.style.display = 'flex';
            } else {
                task.style.display = 'none';
            }
        });
    }

  
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('collapsed');
    }
</script>

</body>
</html>
