@extends('layouts.app')

@section('content')
    <!-- TODO extra <button id="scroll-to-menu" aria-label="Scroll naar menu">
        <i class="fa-solid fa-arrow-down"></i>
    </button> -->
    <div id="suggesties">
        <div id="titel-suggesties">
            <h1>Suggesties</h1>
            <p>(vanaf 17/02/2025)</p>
        </div>
        <div id="body-suggesties">
            <div id="suggestie-container">
                <div class="containers-kolom">
                    <div class="suggestie-tekst">
                        <h2>Suggestie 1</h2>
                        <p>Info suggestie 1</p>
                    </div>
                    <div class="suggestie-tekst">
                        <h2>Suggestie 3</h2>
                        <p>Info suggestie 3</p>
                    </div>
                </div>
                <div class="containers-kolom">
                    <div class="suggestie-tekst">
                        <h2>Suggestie 2</h2>
                        <p>Info suggestie 2</p>
                    </div>
                    <div class="suggestie-tekst">
                        <h2>Suggestie 4</h2>
                        <p>Info suggestie 4</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="menu">
        <h1>Menu</h1>
        <div id="body-menu">
            <div id="navbar-menu">
                <h2>Eten</h2>
                <label class="container">
                    <input type="checkbox" id="item" value="checkvalue"/>
                    <div class="checkmark"></div>
                    <span>Borrelhapjes</span>
                </label>
                <label class="container">
                    <input type="checkbox" id="item" value="checkvalue"/>
                    <div class="checkmark"></div>
                    <span>Kleine kaart</span>
                </label>
                <label class="container">
                    <input type="checkbox" id="item" value="checkvalue"/>
                    <div class="checkmark"></div>
                    <span>Voorgerechten</span>
                </label>
                <label class="container">
                    <input type="checkbox" id="item" value="checkvalue"/>
                    <div class="checkmark"></div>
                    <span>Maaltijdsalades</span>
                </label>
                <label class="container">
                    <input type="checkbox" id="item" value="checkvalue"/>
                    <div class="checkmark"></div>
                    <span>Visgerechten</span>
                </label>
                <label class="container">
                    <input type="checkbox" id="item" value="checkvalue"/>
                    <div class="checkmark"></div>
                    <span>Vleesgerechten</span>
                </label>
                <label class="container">
                    <input type="checkbox" id="item" value="checkvalue"/>
                    <div class="checkmark"></div>
                    <span>Mini for kids</span>
                </label>
                <label class="container">
                    <input type="checkbox" id="item" value="checkvalue"/>
                    <div class="checkmark"></div>
                    <span>Pasta's</span>
                </label>
                <label class="container">
                    <input type="checkbox" id="item" value="checkvalue"/>
                    <div class="checkmark"></div>
                    <span>Vegetarisch</span>
                </label>
                <label class="container">
                    <input type="checkbox" id="item" value="checkvalue"/>
                    <div class="checkmark"></div>
                    <span>Sweets</span>
                </label>
                <label class="container">
                    <input type="checkbox" id="item" value="checkvalue"/>
                    <div class="checkmark"></div>
                    <span>Roomijsjes</span>
                </label>
                <label class="container">
                    <input type="checkbox" id="item" value="checkvalue"/>
                    <div class="checkmark"></div>
                    <span>Kinderijsjes</span>
                </label>
                <br>
                <h2>Drank</h2>
                <label class="container">
                    <input type="checkbox" id="item" value="checkvalue"/>
                    <div class="checkmark"></div>
                    <span>Bieren</span>
                </label>
                <label class="container">
                    <input type="checkbox" id="item" value="checkvalue"/>
                    <div class="checkmark"></div>
                    <span>Frisdranken</span>
                </label>
                <label class="container">
                    <input type="checkbox" id="item" value="checkvalue"/>
                    <div class="checkmark"></div>
                    <span>Warme dranken</span>
                </label>
                <label class="container">
                    <input type="checkbox" id="item" value="checkvalue"/>
                    <div class="checkmark"></div>
                    <span>Aperitieven</span>
                </label>
                <label class="container">
                    <input type="checkbox" id="item" value="checkvalue"/>
                    <div class="checkmark"></div>
                    <span>Spritz</span>
                </label>
                <label class="container">
                    <input type="checkbox" id="item" value="checkvalue"/>
                    <div class="checkmark"></div>
                    <span>Champagne</span>
                </label>
                <label class="container">
                    <input type="checkbox" id="item" value="checkvalue"/>
                    <div class="checkmark"></div>
                    <span>Huiswijn</span>
                </label>
                <label class="container">
                    <input type="checkbox" id="item" value="checkvalue"/>
                    <div class="checkmark"></div>
                    <span>Rode wijnen</span>
                </label>
                <label class="container">
                    <input type="checkbox" id="item" value="checkvalue"/>
                    <div class="checkmark"></div>
                    <span>Witte wijnen</span>
                </label>
                <label class="container">
                    <input type="checkbox" id="item" value="checkvalue"/>
                    <div class="checkmark"></div>
                    <span>Digestief</span>
                </label>
                <label class="container">
                    <input type="checkbox" id="item" value="checkvalue"/>
                    <div class="checkmark"></div>
                    <span>Jenevers</span>
                </label>
                <label class="container">
                    <input type="checkbox" id="item" value="checkvalue"/>
                    <div class="checkmark"></div>
                    <span>Whiskey's</span>
                </label>
                <label class="container">
                    <input type="checkbox" id="item" value="checkvalue"/>
                    <div class="checkmark"></div>
                    <span>Wodka, Rum, Gin</span>
                </label>
                <label class="container">
                    <input type="checkbox" id="item" value="checkvalue"/>
                    <div class="checkmark"></div>
                    <span>Cognac</span>
                </label>
                <label class="container">
                    <input type="checkbox" id="item" value="checkvalue"/>
                    <div class="checkmark"></div>
                    <span>Extra's</span>
                </label>
            </div>
            <div id="gerechten">
                <div class="gerecht">
                    <div class="tekst-links">
                        <h2>Gerecht 1 (Prijs)</h2>
                        <p>info gerecht 1</p>
                    </div>
                    <div class="shopping-cart">
                        <button><i class="fa-solid fa-cart-plus"></i></button>
                    </div>
                </div>
                <div class="gerecht">
                    <div class="tekst-links">
                        <h2>Gerecht 2 (Prijs)</h2>
                        <p>info gerecht 2</p>
                    </div>
                    <div class="shopping-cart">
                        <button><i class="fa-solid fa-cart-plus"></i></button>
                    </div>
                </div>
                <div class="gerecht">
                    <div class="tekst-links">
                        <h2>Gerecht 3 (Prijs)</h2>
                        <p>info gerecht 3</p>
                    </div>
                    <div class="shopping-cart">
                        <button><i class="fa-solid fa-cart-plus"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection