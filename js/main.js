// ===== THEME BUTTON =====
const themeBtn = document.getElementById('themeBtn');
if (themeBtn) {
    themeBtn.addEventListener('click', function() {
        document.body.classList.toggle('light-mode');
        if (document.body.classList.contains('light-mode')) {
            themeBtn.textContent = '☀️';
        } else {
            themeBtn.textContent = '🌙';
        }
    });
}

// ===== LOAD PROJECTS =====
function loadProjects() {
    fetch('get_projects.php')
        .then(response => response.json())
        .then(projects => {
            const container = document.getElementById('projects-container');
            if (projects.length === 0) {
                container.innerHTML = '<p>No projects yet.</p>';
                return;
            }
            container.innerHTML = projects.map(project => `
                <div class="project-card">
                    <h3>${project.title}</h3>
                    <p>${project.description}</p>
                    <span class="tech-tag">${project.tech}</span>
                    <a href="${project.link}" class="btn" target="_blank">View Project</a>
                </div>
            `).join('');
        });
}

loadProjects();

// ===== FORM VALIDATION + SUBMIT =====
const contactForm = document.getElementById('contactForm');
if (contactForm) {
    contactForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const name = document.getElementById('name').value.trim();
        const email = document.getElementById('email').value.trim();
        const message = document.getElementById('message').value.trim();
        if (name === '') { alert('Please enter your name!'); return; }
        if (email === '') { alert('Please enter your email!'); return; }
        if (message === '') { alert('Please enter your message!'); return; }
        fetch('contact.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `name=${name}&email=${email}&message=${message}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Message sent successfully!');
                contactForm.reset();
            } else {
                alert('Error: ' + data.message);
            }
        });
    });
}