@extends('layouts.app')

@section('content')
    <div class="wit-kader-algemeen">
        <h1>Reviews</h1>
        <div id="body-review">
            <div id="nieuwe-review">
                <h2>Plaats een nieuwe review:</h2>
                <div id="inputs">
                    <form id="review-formulier" action="{{ route('reviews.store') }}" method="POST">
                        @csrf
                        <div class="form-group"> <!--BRONVERMELDING Copilot-->
                            <p>Selecteer gerecht: </p>
                            <select id="dish-selection" name="gerecht_id" required>
                                <option value="" disabled selected>Kies een gerecht</option>
                                @foreach($maaltijden as $categorie => $items)
                                    <optgroup label="{{ $categorie }}">
                                        @foreach($items as $maaltijd)
                                            <option value="{{ $maaltijd->gerecht->gerecht_id }}">
                                                {{ $maaltijd->gerecht->naam }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>
                        <div id="sterren">
                            <p>Uw beoordeling:</p>
                            <!-- From Uiverse.io by aguerquin -->
                            <div class="rating">
                                <input type="radio" id="star5" name="rate" value="5" required />
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
                                <textarea name="comment" placeholder="Geef hier extra informatie (optioneel)"></textarea>
                            </div>
                        </div>
                        <button type="submit"> <!-- TODO Library -->
                            Review
                            <div class="arrow-wrapper">
                                <div class="arrow"></div>
                            </div>
                        </button> <!-- Library -->
                    </form>
                </div>
            </div>
            <div id="bestaande-reviews">
                <h2>Mijn reviews:</h2>
                <div id="gegeven-reviews">
                    @forelse($reviews as $review)
                        <div class="gegeven-review" id="review-{{ $review->review_id }}">
                            <div class="info-links">
                                <h3>{{ ucfirst($review->gerecht->naam) }}</h3>
                                <p class="review-comment">{{ $review->extra_info ?: 'Geen extra informatie' }}</p>
                                <small>{{ $review->datum ? date('d/m/Y', strtotime($review->datum)) : 'Geen datum' }}</small>
                                <button class="edit-review-btn" data-review-id="{{ $review->review_id }}">Bewerk Opmerking</button>
                            </div>
                            <div class="info-rechts">
                                <div class="stars">
                                    @for ($i=0 ; $i < $review->score; $i++)
                                        <i class="fa-solid fa-star"></i>
                                    @endfor
                                </div>
                            </div>
                            {{-- Hidden Edit Form --}} <!-- CoPilot -->
                            <form action="{{ route('reviews.update', $review->review_id) }}" method="POST" class="edit-review-form" style="display: none; width: 100%; margin-top: 1rem; max-width: fit-content">
                                @csrf
                                @method('PATCH')
                                <textarea name="comment" class="form-control" rows="3">{{ $review->extra_info }}</textarea>
                                <button type="submit" class="btn btn-primary btn-sm mt-2">Opslaan</button>
                                <button type="button" class="btn btn-secondary btn-sm mt-2 cancel-edit-btn" data-review-id="{{ $review->review_id }}">Annuleren</button>
                            </form>
                            {{-- Hidden Delete Form --}}
                            <form action="{{ route('reviews.destroy', $review->review_id) }}" method="POST" class="delete-review-form" style="display: none; width: 100%; margin-top: 0.5rem; max-width: fit-content;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm mt-2" onclick="return confirm('Weet je zeker dat je deze review wilt verwijderen?')">Verwijder</button>
                            </form>
                        </div>
                    @empty
                        <p>Je hebt nog geen reviews gegeven.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection