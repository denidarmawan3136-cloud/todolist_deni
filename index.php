<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>To-Do List</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #F08B51;
      font-family: 'Segoe UI', sans-serif;
    }
    .container {
      margin-top: 60px;
      max-width: 700px;
    }
    .card {
      animation: fadeIn 0.8s ease-in-out;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-15px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .task-done {
      text-decoration: line-through;
      color: gray;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="card shadow">
      <div class="card-body">
        <h3 class="card-title mb-4 text-center">
          <img src="https://cdn-icons-png.flaticon.com/512/4140/4140048.png" width="32">
          TO-DO LIST
        </h3>

        <form id="taskForm" class="d-flex mb-3">
          <input type="text" id="taskInput" class="form-control me-2" placeholder="Tulis tugas baru..." required>
          <button type="submit" class="btn btn-primary">Tambah</button>
        </form>

        <ul class="list-group" id="taskList"></ul>
      </div>
    </div>
  </div>

  <script>
    let tasks = []

    function renderTasks() {
      const taskList = document.getElementById("taskList");
      taskList.innerHTML = "";
      tasks.forEach((task, index) => {
        const li = document.createElement("li");
        li.className = "list-group-item d-flex justify-content-between align-items-center";

        const label = document.createElement("span");
        label.innerHTML = task.done ? `<span class='task-done'>${task.name}</span>` : task.name;

        const inputEdit = document.createElement("input");
        inputEdit.type = "text";
        inputEdit.className = "form-control me-2 d-none";
        inputEdit.value = task.name;

        const divLeft = document.createElement("div");
        divLeft.className = "d-flex align-items-center";

        const checkbox = document.createElement("input");
        checkbox.type = "checkbox";
        checkbox.checked = task.done;
        checkbox.className = "form-check-input me-2";
        checkbox.onchange = () => {
          tasks[index].done = !tasks[index].done;
          renderTasks();
        };

        divLeft.appendChild(checkbox);
        divLeft.appendChild(label);
        divLeft.appendChild(inputEdit);

        const editBtn = document.createElement("button");
        editBtn.className = "btn btn-warning btn-sm me-2";
        editBtn.innerText = "Edit";
        editBtn.onclick = () => {
          label.classList.add("d-none");
          inputEdit.classList.remove("d-none");
          inputEdit.focus();
        };

        const saveBtn = document.createElement("button");
        saveBtn.className = "btn btn-success btn-sm me-2";
        saveBtn.innerText = "Simpan";
        saveBtn.onclick = () => {
          if (inputEdit.value.trim()) {
            tasks[index].name = inputEdit.value.trim();
            renderTasks();
          }
        };

        const deleteBtn = document.createElement("button");
        deleteBtn.className = "btn btn-danger btn-sm";
        deleteBtn.innerText = "Hapus";
        deleteBtn.onclick = () => {
          tasks.splice(index, 1);
          renderTasks();
        };

        const divRight = document.createElement("div");
        divRight.className = "btn-group";
        divRight.appendChild(editBtn);
        divRight.appendChild(saveBtn);
        divRight.appendChild(deleteBtn);

        li.appendChild(divLeft);
        li.appendChild(divRight);
        taskList.appendChild(li);
      });
    }

    document.getElementById("taskForm").onsubmit = (e) => {
      e.preventDefault();
      const input = document.getElementById("taskInput");
      const task = input.value.trim();
      if (task) {
        tasks.push({ name: task, done: false });
        input.value = "";
        renderTasks();
      }
    }
  </script>
</body>
</html>
