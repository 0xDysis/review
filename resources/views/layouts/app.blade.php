<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'POLARIS') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    @vite('resources/sass/app.scss')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/1.4.0/p5.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    </head>
<body>
<div id="app">
<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light {{ Route::currentRouteName() == 'home' || Route::currentRouteName() == 'browse' ? 'vertical-navbar' : 'horizontal-navbar' }}">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-center" id="navbarNavDropdown">
        <ul class="navbar-nav">
            @auth
                <li class="nav-item active">
                    <a class="nav-link" href="/home">
                        @if(Route::currentRouteName() == 'home' || Route::currentRouteName() == 'browse')
                            <i class="fas fa-home"></i>
                        @endif
                        Home
                    </a>
                </li>
            @endauth
            <li class="nav-item">
                <a class="nav-link" href="/browse">
                    @if(Route::currentRouteName() == 'home' || Route::currentRouteName() == 'browse')
                        <i class="fas fa-search"></i>
                    @endif
                    Browse
                </a>
            </li>
            @guest
                <li class="nav-item">
                    <a class="nav-link" href="/login">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/register">Register</a>
                </li>
            @else
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        @if(Route::currentRouteName() == 'home' || Route::currentRouteName() == 'browse')
                            <i class="fas fa-user"></i>
                        @endif
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                @if(Route::currentRouteName() == 'home' || Route::currentRouteName() == 'browse')
                                    <i class="fas fa-sign-out-alt"></i>
                                @endif
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
            @endguest
        </ul>
    </div>
</nav>



</div>






        <main class="container py-4">
            @yield('content')
        </main>
    </div>
    <div id="myCanvas"></div>

    @if (Request::is('login') || Request::is('register'))
<script>
    var sketch = function(p) {
        

var sketch = function(p) {
    var inc = 0.1;
    var scl = 20;
    var cols, rows;
    var zoff = 0;
    var particles = [];
    var flowfield = [];
  
    p.setup = function() {
      var canvas = p.createCanvas(p.windowWidth, p.windowHeight);
      canvas.parent('myCanvas');
canvas.position(0, 0);
canvas.style('z-index', '-2');

     
    
      cols = p.floor(p.width / scl);
      rows = p.floor(p.height / scl);
  
      flowfield = new Array(cols * rows);
  
      for (var i = 0; i < 300; i++) {
        particles[i] = new Particle(p);
      }
      p.background(236,240,243);
    };
  
    p.draw = function() {
      var yoff = 0;
      for (var y = 0; y < rows; y++) {
        var xoff = 0;
        for (var x = 0; x < cols; x++) {
          var index = x + y * cols;
          var angle = p.noise(xoff, yoff, zoff) * p.TWO_PI * 4;
          var v = p.createVector(p.cos(angle), p.sin(angle));
          v.setMag(0.8);
          flowfield[index] = v;
          xoff += inc;
        }
        yoff += inc;
        zoff += 0.00008;
        
      }
  
      for (var i = 0; i < particles.length; i++) {
        particles[i].follow(flowfield);
        particles[i].update();
        particles[i].edges();
        particles[i].show();
      }
    };
  
    function Particle(p) {
      this.pos = p.createVector(p.random(p.width), p.random(p.height));
      this.vel = p.createVector(0, 0);
      this.acc = p.createVector(0, 0);
      this.maxspeed = 4;
  
      this.prevPos = this.pos.copy();
  
      this.update = function() {
        this.vel.add(this.acc);
        this.vel.limit(this.maxspeed);
        this.pos.add(this.vel);
        this.acc.mult(0);
      };
  
      this.follow = function(vectors) {
        var x = p.floor(this.pos.x / scl);
        var y = p.floor(this.pos.y / scl);
        var index = x + y * cols;
        var force = vectors[index];
        this.applyForce(force);
      };
  
      this.applyForce = function(force) {
        this.acc.add(force);
      };
  
      this.show = function() {
        p.stroke(160, 160, 160, 10);
        p.line(this.pos.x, this.pos.y, this.prevPos.x, this.prevPos.y);
        this.updatePrev();
      };
      
  
      this.updatePrev = function() {
        this.prevPos.x = this.pos.x;
        this.prevPos.y = this.pos.y;
      };
  
      this.edges = function() {
        if (this.pos.x > p.width) {
          this.pos.x = 0;
          this.updatePrev();
        }
        if (this.pos.x < 0) {
          this.pos.x = p.width;
          this.updatePrev();
        }
        if (this.pos.y > p.height) {
          this.pos.y = 0;
          this.updatePrev();
        }
        if (this.pos.y < 0) {
          this.pos.y = p.height;
          this.updatePrev();
        }
      };
    }
  };
  window.onload = function() {
    new p5(sketch);
  };


  
  
 
 
    };
    document.addEventListener('DOMContentLoaded', function() {
        new p5(sketch);
    });
</script>
@endif
<script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchForm = document.querySelector('.search-form');
            const searchInput = document.querySelector('.search-input');
            const searchResultsContainer = document.querySelector('.search-results-container');
            const searchCard = document.querySelector('.search-card');

            searchForm.addEventListener('submit', function(event) {
                event.preventDefault();
                const query = searchInput.value.trim();

                if (query.length > 0) {
                    fetchSearchResults(query);
                }
            });

            searchInput.addEventListener('focus', function() {
                searchCard.style.display = 'block';
            });

            searchInput.addEventListener('blur', function() {
                searchCard.style.display = 'none';
            });

            async function fetchSearchResults(query) {
                const response = await fetch(`/search?query=${encodeURIComponent(query)}`);
                const searchResults = await response.json();

                // Update the search results container with the new search results
                searchResultsContainer.innerHTML = '';
                searchResults.forEach(result => {
                    const resultElement = document.createElement('div');
                    resultElement.classList.add('search-result');
                    resultElement.textContent = result.name; // Replace 'name' with the appropriate field from your search results
                    searchResultsContainer.appendChild(resultElement);
                });
            }
        });
    </script>
@vite('resources/js/app.js')
</body>

