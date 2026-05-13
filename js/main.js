// ===== THEME TOGGLE =====
document.addEventListener('DOMContentLoaded', function() {
    const themeToggle = document.getElementById('themeToggle');
    if (!themeToggle) return;

    function updateTheme() {
        document.body.classList.toggle('light-mode', themeToggle.checked);
    }

    themeToggle.addEventListener('change', updateTheme);
    updateTheme();
});

// ===== LOAD PROJECTS (AJAX) =====
function loadProjects() {
    const container = document.getElementById('projects-container');
    fetch('get_projects.php')
        .then(response => response.json())
        .then(projects => {
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
        })
        .catch(err => {
            container.innerHTML = '<p>Failed to load projects.</p>';
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
        })
        .catch(err => {
            alert('Failed to send message. Please try again.');
        });
    });
}

// ===== USER DATA =====
const userName = "Mouaz Kadah";
const userTitle = "Software Engineering Student";

const skills = ["Python", "HTML/CSS", "JavaScript", "SQL", "C/C++", "Cyber Security"];

const developerProfile = {
    name: userName,
    title: userTitle,
    age: 21,
    education: "Software Engineering",
    year: 3,
    skills: skills,
    interests: ["Cyber Security", "Full-Stack Development"]
};

// Console logs
console.log("Name:", userName);
console.log("Title:", userTitle);
console.log("Skills array:", skills);
console.log("First skill:", skills[0]);
console.log("Developer Profile:", developerProfile);
console.log("Profile name:", developerProfile.name);
console.log("Profile interests:", developerProfile.interests);

// ===== BOM EXAMPLES =====
console.log("Browser language:", navigator.language);
console.log("Screen width:", screen.width);
console.log("Current URL:", location.href);

// ===== EVENT DELEGATION =====
const navLinks = document.querySelector('.nav-links');
if (navLinks) {
    navLinks.addEventListener('click', function(event) {
        if (event.target.tagName === 'A') {
            console.log("Clicked nav link:", event.target.textContent);
        }
    });
}