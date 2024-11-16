// Define a mapping of skills to their corresponding icon classes
// Define a mapping of skills to their corresponding icon classes
(function($) {
    let strContainerClass = ".PANE_HERO";
    let strShowClass = "HERO_SHOW";
    let strHideClass = "HERO_HIDE";
    
    // Define a mapping of skills to their corresponding icon classes
    const objIconMap = {
        "JavaScript": "bx bxl-javascript",
        "TypeScript": "bx bxl-typescript",
        "React": "bx bxl-react",
        "Redux": "",
        "Node.js": "bx bxl-nodejs",
        "Express": "",
        "MongoDB": "",
        "MySQL": "",
        "PostgreSQL": "",
        "GraphQL": "",
        "Python": "bx bxl-python",
        "Django": "",
        "PyTorch": "",
        "FastAPI": "",
        "Django Channels": "",
        "Docker": "bx bxl-docker"
    };

    // Wait for the document to be fully loaded
    $(document).ready(function() {
        // Select the hero div where skills will be displayed
        const objHero = $(strContainerClass);

        // Iterate over each skill in the iconMap
        $.each(objIconMap, function(strSkill, strIconClass) {
            // Create a new div element for each skill
            const objSkillElement = $('<div></div>', {
                class: strShowClass, // Assign the 'HERO_SHOW' class
                html: strIconClass ? `<i class="${strIconClass}"></i>` : strSkill // If an icon class is available, use it; otherwise, display the skill name
            });
            // Append the skill element to the hero div
            objHero.append(objSkillElement);
        });

        // Function to animate the skills
        function animateSkills() {
            // Iterate over each skill element
            $(`.${strShowClass}`).each(function(numIndex) {
                const objSkillElement = $(this);
                // Set a timeout to add the 'HERO_SHOW' class, creating a staggered animation effect
                setTimeout(function() {
                    objSkillElement.addClass(strHideClass);
                }, numIndex * 200);

                // Set a timeout to remove the 'HERO_SHOW' class after 5 seconds, creating a fade-out effect
                setTimeout(function() {
                    objSkillElement.removeClass(strHideClass);
                }, 5000 + numIndex * 200);
            });
        }

        // Call the animateSkills function to start the animation
        animateSkills();
        // Set an interval to repeat the animation every 10 seconds
        setInterval(animateSkills, 10000);
    });
})(jQuery);