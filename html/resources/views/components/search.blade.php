<div class="search">
    <form method="GET" class="d-flex d-lg-inline flex-grow-1 flex-lg-grow-0" action="#" autocomplete="off">
        <div class="input-group mb-10 ">
            <input type="text" class="form-control from-control-sm" id="q" name="q" placeholder="Enter Anime for search">
            <div class="input-group-append">
                <span class="input-group-text" id="searchButton" style="cursor: pointer"><i class="fas fa-search"></i></span>
            </div>
        </div>
    </form>
    <div id="results" class="no-display"></div>
</div>


@push('script')
    <script type="text/javascript">
        $(() => {
            const input = document.querySelector('#q');
            const searchBtn = document.querySelector('#searchButton');
            const resultsDiv = document.querySelector('#results');
            // Listen for all clicks on the document
            document.addEventListener('click', function (event) {
                if (!event.target.closest('#results')) {
                    resultsDiv.classList.add('no-display');
                }
            }, false);

            input.addEventListener('input', async (e) => {
                if (input.value.length > 1) {
                    const animes = await searchAnimes(input.value);

                    resultsDiv.innerHTML = "";

                    if (Object.keys(animes.data).length > 0) {
                        const li = createLinkAllResult(input.value);
                        resultsDiv.appendChild(li);

                        for(let i = 0; i < Object.keys(animes.data).length; i++) {
                            createNewAnimeResult(animes?.data[i]);
                        }
                    }
                    else {
                        // show no result msg
                        const noAnime = document.createTextNode('No anime recorded !');
                        resultsDiv.appendChild(noAnime);
                    }
                    // show div results
                    resultsDiv.classList.remove('no-display');

                }
            });

            searchBtn.addEventListener('click', (e) => {
                if (input.value.length > 1) {
                    const url = new URL("{{route('animes.search')}}");
                    url.searchParams.append('q', input.value);
                    window.location.href =  url.href;
                }

            });
        });

        const searchAnimes = async (val) => {
            const url = new URL("{{route('animes.search')}}");
            url.searchParams.append('q', val);

            const response = await axios.get(url.href);
            if (!response.statusText === 'OK') {
                throw new Error(`[fetchError] : An error occured when fetching animes with code: ${response.status}`);
            }
            return response?.data;
        };

        const createLinkAllResult = (inputVal) => {
            const li = document.createElement('li');
            const link = document.createElement('a');
            const url = new URL("{{route('animes.search')}}");
            url.searchParams.append('q', inputVal);
            link.href = url.href;
            link.innerText = 'See all results';
            li.classList.add('mb-4', 'text-center');
            link.classList.add('mx-auto');
            li.appendChild(link);
            return li;
        };

        const createNewAnimeResult = (anime) => {
            // <li><a href="route('animes.show', anime.id')"><img src=... />Anime Toto</a></li>
            const resultsDiv = document.querySelector('#results');

            const hr = document.createElement('hr');
            const img = document.createElement('img');
            const li = document.createElement('li');
            const a = document.createElement('a');
            const title = document.createTextNode(anime?.title);

            a.href = "/animes/" + anime?.title;
            img.src = anime?.poster_image;
            img.classList.add('img-fluid', 'poster');
            a.appendChild(img);
            a.appendChild(title);
            li.appendChild(a);
            resultsDiv.appendChild(li);
            resultsDiv.appendChild(hr);
        };
    </script>
@endpush
