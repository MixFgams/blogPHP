<!DOCTYPE html>
<html>
    <head>
        <link rel="icon" src="img/obLogo.png" type="image/x-icon">
        <link rel="stylesheet" href="style.css">
        <script src="script.js"></script>
    </head>
    <body>
        <?php include 'otherPages/header.php'?>
        <!--A supprimer plus tard, c etait juste pour le fun-->
        <script>
            window.onload = function() {
                const sections = document.querySelectorAll('section');
                sections.forEach(section => {
                    section.style.opacity = 0;
                    section.style.transform = 'translateY(20px)';
                    setTimeout(() => {
                        section.style.transition = 'opacity 1s ease, transform 1s ease';
                        section.style.opacity = 1;
                        section.style.transform = 'translateY(0)';
                    }, 100);
                });
            };
        </script>
        <!------------------------------------------------------------>

        <main>
            <!--A supprimer plus tard, c etait juste pour le fun-->
            <h1 id="animated-text">Aizen Kosuke : L'Intellectuel Stratégique</h1>

            <section class="parallax">
                <h2>Aizen Sosuke</h2>
                <img src="img/Aizen.png" alt="Aizen Sosuke" style="width: 100%; max-width: 400px; border: 2px solid #d32f2f; border-radius: 8px;">
                <p>Aizen est connu pour son intelligence et sa capacité à manipuler les autres à son avantage.</p>
            </section>


            <section>
                <h2>Un Génie Manipulateur</h2>
                <p>Dès le début, Aizen se distingue par son intelligence exceptionnelle. En tant que capitaine de la 5ème division des Shinigami, il a démontré une maîtrise impressionnante des arts de la guerre et de la manipulation. Son plan complexe pour renverser l'ordre établi du Seireitei a été méticuleusement conçu, impliquant des alliances inattendues et des tromperies subtiles. Aizen utilise sa compréhension psychologique des autres pour les amener à agir selon ses désirs, rendant ses machinations presque impossibles à détecter.</p>
            </section>

            <section>
                <h2>Maîtrise des Pouvoirs</h2>
                <p>En plus de son intelligence, Aizen possède des capacités surhumaines. Son zanpakuto, Kyoka Suigetsu, lui permet de manipuler les perceptions de ses ennemis, les rendant vulnérables à ses attaques. Cette capacité d'illusion est le reflet de son esprit stratégique, car il utilise cette technique non seulement pour attaquer, mais aussi pour semer le doute et la confusion parmi ses adversaires.</p>
            </section>

            <section>
                <h2>Intrigues Complexes</h2>
                <p>Les intrigues d'Aizen sont parmi les plus captivantes de l'univers. Ses machinations mettent en lumière des thèmes tels que la vérité et la perception, amenant les personnages et les spectateurs à se demander qui est réellement le "méchant". Sa capacité à anticiper les mouvements de ses ennemis et à élaborer des plans de rechange en cas d'échec témoigne d'une préparation minutieuse et d'une vision à long terme.</p>
            </section>

            <section>
                <blockquote>"La vérité est une illusion."</blockquote>
            </section>

            <section>
                <h2>Conclusion</h2>
                <p>Aizen Kosuke est bien plus qu'un simple antagoniste ; il est un maître de la manipulation et de l'intelligence, et son impact sur l'univers continue d'être ressenti à travers ses intrigues complexes et ses capacités surhumaines.</p>
            </section>
            <!------------------------------------------------------------>
        </main>
        <?php include 'otherPages/footer.php'?>
    </body>
</html>