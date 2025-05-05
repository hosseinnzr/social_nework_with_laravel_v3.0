<div> 
    <div id="communicationcollapseOne" class="accordion-collapse collapse show" aria-labelledby="communicationOne" data-bs-parent="#communications">
        <div class="accordion-body">

            @if ($state == 0)
                <h5 class="card-title">Why are you reporting this post?</h5>

                <form wire:submit.prevent="sendReport" method="POST" class="mt-4">
                    @csrf
                
                    @php
                        $reportReasons = [
                            "I just don't like it",
                            "Bullying or unwanted contact",
                            "Suicide, self-injury or eating disorders",
                            "Violence, hate or exploitation",
                            "Selling or promoting restricted items",
                            "Nudity or sexual activity",
                            "Scam, fraud or spam",
                            "False information"
                        ];
                    @endphp
                
                    @foreach($reportReasons as $index => $reason)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="ComRadio"
                                id="ComRadio{{ $index }}" wire:model="selectedReason" value="{{ $reason }}">
                            <label class="form-check-label" for="ComRadio{{ $index }}">
                                {{ $reason }}
                            </label>
                        </div>
                    @endforeach
                                
                    <style>
                        .loader-container {
                            margin-top: 4px;
                            width: 100%;
                            height: 4px;
                            background-color: #e0e0e0;
                            position: relative;
                            overflow: hidden;
                            border-radius: 0 0 5px 5px;
                        }
                
                        .loader-line {
                            width: 10%;
                            height: 100%;
                            background-color: #0f6fec;
                            position: absolute;
                            top: 0;
                            left: 0;
                            animation: moveLine 1s linear infinite;
                        }
                
                        @keyframes moveLine {
                            0% { left: 0; }
                            100% { left: 100%; }
                        }
                    </style>
                
                    <div style="margin-top: 10px">
                        <div wire:loading.remove>
                            <button type="submit" class="btn btn-primary w-100">
                                Send Report
                            </button>
                        </div>
                    
                        <div wire:loading>
                            <button type="button" class="btn btn-primary w-100" disabled>
                                Sending Report...
                                <div class="loader-container">
                                    <div class="loader-line"></div>
                                </div>
                            </button>
                        </div>
                    </div>

                </form>
            @else
                <div style="text-align: center">
                    <i style="color: #58c322; font-size: 60px;" class="bi bi-check-circle"></i>
                    <h5>Thanks for your feedback</h5>
                    <p>When you see something you don't like on Instagram, you can report it if it doesn't follow our Community Standards, or you can remove the person who shared it from your experience.</p>
                </div>

                <form wire:submit.prevent="backToReport" method="POST" class="mt-4">
                    <button type="submit" class="btn btn-outline-secondary w-100">Back to report egain</button>
                </form>

            @endif
            
        </div>
    </div>
</div>
