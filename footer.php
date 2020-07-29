<!-- <div class="row" style="position:relative; bottom: 320px; padding-left: 100px;">
    <div class="container">
       <h1 class="ml1">
            <span class="text-wrapper">
              <span class="line line1" style="background-color: white;"></span>
              <span class="letters" style="color: white; font-size: 100px;">EASY-CRPC</span>
              <span class="line line2" style="background-color: white;"></span>
            </span>
          </h1>
    </div>
</div> -->

<!--<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>-->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>-->
<!--<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>-->
<!--<script src="./JS/scripts.js"></script>-->


<!-- sourced from: https://tobiasahlin.com/moving-letters/#1 -->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js"></script>-->
<!--<script type="text/javascript">-->

<!--var textWrapper = document.querySelector('.ml1 .letters');-->
<!--textWrapper.innerHTML = textWrapper.textContent.replace(/\S/g, "<span class='letter'>$&</span>");-->

<!--anime.timeline({loop: true})-->
<!--  .add({-->
<!--    targets: '.ml1 .letter',-->
<!--    scale: [0.3,1],-->
<!--    opacity: [0,1],-->
<!--    translateZ: 0,-->
<!--    easing: "easeOutExpo",-->
<!--    duration: 600,-->
<!--    delay: (el, i) => 70 * (i+1)-->
<!--  }).add({-->
<!--    targets: '.ml1 .line',-->
<!--    scaleX: [0,1],-->
<!--    opacity: [0.5,1],-->
<!--    easing: "easeOutExpo",-->
<!--    duration: 700,-->
<!--    offset: '-=875',-->
<!--    delay: (el, i, l) => 80 * (l - i)-->
<!--  }).add({-->
<!--    targets: '.ml1',-->
<!--    opacity: 0,-->
<!--    duration: 1000,-->
<!--    easing: "easeOutExpo",-->
<!--    delay: 1000-->
<!--  });-->
<!--</script>-->
<!--  </body>-->
<!--</html>-->

   <!-- footer -->
   <footer>
        <p>Easy-CRPC &copy; 2020</p>
    </footer>
    
    <!-- wrapper ends -->
    </div>
    
<script src="./JS/scripts.js"></script>


<!-- sourced from: https://tobiasahlin.com/moving-letters/#1 -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js"></script>
<script type="text/javascript">
  // Wrap every letter in a span
var textWrapper = document.querySelector('.ml1 .letters');
textWrapper.innerHTML = textWrapper.textContent.replace(/\S/g, "<span class='letter'>$&</span>");

anime.timeline({loop: true})
  .add({
    targets: '.ml1 .letter',
    scale: [0.3,1],
    opacity: [0,1],
    translateZ: 0,
    easing: "easeOutExpo",
    duration: 600,
    delay: (el, i) => 70 * (i+1)
  }).add({
    targets: '.ml1 .line',
    scaleX: [0,1],
    opacity: [0.5,1],
    easing: "easeOutExpo",
    duration: 700,
    offset: '-=875',
    delay: (el, i, l) => 80 * (l - i)
  }).add({
    targets: '.ml1',
    opacity: 0,
    duration: 1000,
    easing: "easeOutExpo",
    delay: 1000
  });
</script>
</body>
</html>