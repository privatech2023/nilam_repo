<div>
    <div class="bread" >
        <div >
            <a href="{{url('/')}}" style="text-decoration: none;">
                <button type="button" class="btn btn-md" style="margin-top: 7px; background-color: #60377b; border-radius: 30px; color: white; box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5"/>
                    </svg>
                </button>
            </a>
        </div>
        
            @livewire('dropdown')
    </div>
    
    <div class="content-wrapper remove-background">
        <div id="frame">
            <nav class="navbar navbar-light bg-light">
                
                <span class="text-secondary"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle" viewBox="0 0 16 16">
                    <path d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.15.15 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.2.2 0 0 1-.054.06.1.1 0 0 1-.066.017H1.146a.1.1 0 0 1-.066-.017.2.2 0 0 1-.054-.06.18.18 0 0 1 .002-.183L7.884 2.073a.15.15 0 0 1 .054-.057m1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767z"/>
                    <path d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z"/>
                  </svg>TEXT TO SPEECH</span>
            </nav>
            <div style=" margin-top: 20px; margin-left: 20px;" >
                <div class="row">
                    <div style="width:60%;">
                        <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select a
                            Language</label>
                        <select id="countries" class="form-control" wire:model="selected_language"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            @foreach ($languages as $id => $language)
                                <option value="{{ $id }}">{{ $language }}</option>
                            @endforeach
                        </select>

                        <div class="my-4 ">
                            <label for="text" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Text
                                ({{ $message_length }}/160)</label>
                            <textarea id="text" class="form-control" wire:model="message"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                maxlength="160" rows="3"></textarea>
                        </div>
                        
                        <div class="modal-footer" style="justify-content: flex-start; padding: 0rem; margin-top: 10px;">
                        <button class="button-29" role="button"  wire:click="sendTextToSpeech"><svg style="margin-right:6px;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle" viewBox="0 0 16 16">
                            <path d="M8.997 1.665a1.13 1.13 0 0 0-1.994 0l-6.26 11.186a1.13 1.13 0 0 0 .997 1.664h12.52a1.13 1.13 0 0 0 .997-1.664L8.997 1.665zM8.28 12.856a1.1 1.1 0 0 0 1.438-.002l5.45-9.75a1.1 1.1 0 0 0-.718-1.844H3.55a1.1 1.1 0 0 0-.718 1.844l5.448 9.75zM8.997 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                        </svg>Send message</button>
                    </div>
                </div>
            </div>
        </div>
    

        
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Livewire.on('banner-message', function (data) {
                    if (data.style === 'success') {
                        alert(data.message);
                        $('#message').val('');
                    } else {
                        alert(data.message);
                        $('#message').val('');
                    }
                });
            });
        </script>
    </div> 
        
    
    
    
    