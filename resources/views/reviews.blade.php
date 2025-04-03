@extends('layouts.app')

@section('content')
    <div id="reviews">
        <div id="titel-reviews">
            <h1>Reviews</h1>
        </div>
        <div id="body-review">
            <div id="nieuwe-review">
                <h2>Plaats een nieuwe review:</h2>
                <div id="inputs">
                    <form id="review-form">
                        <div class="form-group"> <!--BRONVERMELDING Copilot-->
                            <p>Selecteer gerecht: </p>
                            <select id="dish-selection" name="dish" required>
                                <option value="" disabled selected>Kies een gerecht</option>
                                <optgroup label="Voorgerechten">
                                    <option value="tomatensoep">Tomatensoep</option>
                                    <option value="carpaccio">Rundscarpaccio</option>
                                    <option value="garnaalkroketten">Garnaalkroketten</option>
                                </optgroup>
                                <optgroup label="Hoofdgerechten">
                                    <option value="steak">Steak met frietjes</option>
                                    <option value="stoofvlees">Stoofvlees</option>
                                    <option value="pasta">Pasta Bolognese</option>
                                    <option value="vispannetje">Vispannetje</option>
                                </optgroup>
                                <optgroup label="Desserts">
                                    <option value="dame-blanche">Dame Blanche</option>
                                    <option value="tiramisu">Tiramisu</option>
                                    <option value="cheesecake">Cheesecake</option>
                                </optgroup>
                            </select>
                        </div>

                        <div id="sterren">
                            <p>Uw beoordeling:</p>
                            <!-- From Uiverse.io by aguerquin -->
                            <div class="rating">
                                <input type="radio" id="star5" name="rate" value="5" />
                                <label title="Excellent!" for="star5">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512">
                                        <path
                                            d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"
                                        ></path>
                                    </svg>
                                </label>
                                <input value="4" name="rate" id="star4" type="radio" />
                                <label title="Great!" for="star4">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512">
                                        <path
                                            d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"
                                        ></path>
                                    </svg>
                                </label>
                                <input value="3" name="rate" id="star3" type="radio" />
                                <label title="Good" for="star3">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512">
                                        <path
                                            d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"
                                        ></path>
                                    </svg>
                                </label>
                                <input value="2" name="rate" id="star2" type="radio" />
                                <label title="Okay" for="star2">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512">
                                        <path
                                            d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"
                                        ></path>
                                    </svg>
                                </label>
                                <input value="1" name="rate" id="star1" type="radio" />
                                <label title="Bad" for="star1">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512">
                                        <path
                                            d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"
                                        ></path>
                                    </svg>
                                </label>
                            </div>
                        </div>

                        <div id="informatie-review">
                            <div id="input-box">
                                <textarea placeholder="Geef hier extra informatie (optioneel)"></textarea>
                            </div>
                        </div>
                    </form>
                    <button> <!-- TODO Library -->
                        Review
                        <div class="arrow-wrapper">
                            <div class="arrow"></div>
                        </div>
                    </button> <!-- Library -->
                </div>
            </div>
            <div id="bestaande-reviews">
                <h2>Mijn reviews:</h2>
                <div id="gegeven-reviews">
                    <div class="gegeven-review">
                        <div class="info-links">
                            <h3>Review 1</h3>
                            <p>Extra info</p>
                        </div>
                        <div class="info-rechts">
                            <p>Aantal sterren</p>
                        </div>
                    </div>
                    <div class="gegeven-review">
                        <div class="info-links">
                            <h3>Review 2</h3>
                            <p>Extra info</p>
                        </div>
                        <div class="info-rechts">
                            <p>Aantal sterren</p>
                        </div>
                    </div>
                    <div class="gegeven-review">
                        <div class="info-links">
                            <h3>Review 3</h3>
                            <p>Extra info</p>
                        </div>
                        <div class="info-rechts">
                            <p>Aantal sterren</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection