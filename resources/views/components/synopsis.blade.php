<div class="synopsis-panel">
  <div class="row">

    <div class="col-sm-2">
      <a {{ $syn_mal ? 'target="_blank"' : '' }} href="{{ $syn_show->details_url }}">
        <img class="img-thumbnail synopsis-thumbnail" src="{{ $syn_show->thumbnail_url }}" alt="{{ $syn_show->title }} - Thumbnail">
      </a>
    </div>

    <div class="col-sm-10">
      <div class="synopsis-title">
        <a {{ $syn_mal ? 'target="_blank"' : '' }} href="{{ $syn_show->details_url }}">{{ $syn_show->title }}</a>
      </div>

      @if(!$syn_mal)
        <div class="row">
          <div class="col-sm-9">
            <div class="synopsis-description">
              {!! $syn_show->description !!}
              <!--
              <div class="synopsis-description-top">
                {!! $syn_show->description !!}
              </div>
              -->
              <!--
              <div class="collapsed toggle" data-toggle="collapse" data-target="#description-{{ $syn_unique }}">
                &laquo; Toggle Description &raquo;
              </div>
              <div class="collapse" id="description-{{ $syn_unique }}">
                {!! $syn_show->description !!}
              </div>
              -->
            </div>
          </div>

          <div class="col-sm-3">
            <div class="synopsis-details">
              <p><strong>Type:</strong> {{ ucwords($syn_show->type) }}</p>
              <p><strong>Episodes:</strong> {{ $syn_show->episode_amount or 'Unknown' }}</p>
              <p>
                <strong>Duration:</strong>
                @if(isset($syn_show->episode_duration))
                  {{ $syn_show->episode_duration }} min. per ep.
                @else
                  Unknown
                @endif
              </p>
              <p>
                <strong>Airing:</strong>
                @if(empty($syn_show->airing_start) && empty($syn_show->airing_end))
                  Unknown
                @else
                  {{ !empty($syn_show->airing_start) ? $syn_show->airing_start->toFormattedDateString() : '?' }} to {{ !empty($syn_show->airing_end) ? $syn_show->airing_end->toFormattedDateString() : '?' }}
                @endif
              </p>
            </div>
          </div>
        </div>

      @else
        <div class="row">
          <div class="col-sm-12">
            <div class="synopsis-description">
              <p>This show is not in our database yet.</p>
              <form action="{{ url('/anime/add') }}" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="title" value="{{ $syn_show->title }}"></input>
                <button type="submit" class="btn btn-primary">Click To Add</button>
              </form>
            </div>
          </div>
        </div>
      @endif

      @if(!$syn_mal)
        <div class="synopsis-bottombar">
          <div class="row">
            @if(!empty($syn_video))
              <div class="col-sm-3">
                <a href="{{ $syn_video->episode_url }}">
                  Episode {{ $syn_video->episode_num }} Has Aired
                </a>
              </div>
              <div class="col-sm-3">
                Episode Type: {{ $syn_video->translation_type === 'sub' ? 'Subbed' : '' }}{{ $syn_video->translation_type === 'dub' ? 'Dubbed' : ''}}
              </div>
              <div class="col-sm-3">
                Uploaded by <a href="{{ $syn_video->streamer->details_url }}">{{ $syn_video->streamer->name }}</a>
              </div>
              <div class="col-sm-3">
                Uploaded on {{ $syn_video->uploadtime->format('M j, Y (l)') }}
              </div>

            @else

              <div class="col-sm-6">
                @if(!$syn_show->videos_initialised)
                  Latest Subbed: Searching for episodes ...
                @elseif(isset($syn_show->latest_sub->episode_num))
                  <a href="{{ url("/anime/$syn_show->id/sub/episode-$syn_show->latest_sub->episode_num") }}">
                    Latest Subbed: Epsiode {{ $syn_show->latest_sub->episode_num }}; Uploaded on {{ $syn_show->latest_sub->uploadtime->format('M j, Y (l)') }}
                  </a>
                @else
                  Latest Subbed: No episodes available
                @endif
              </div>
              <div class="col-sm-6">
                @if(!$syn_show->videos_initialised)
                  Latest Dubbed: Searching for episodes ...
                @elseif(isset($syn_show->latest_dub->episode_num))
                  <a href="{{ url("/anime/$syn_show->id/dub/episode-$syn_show->latest_dub->episode_num") }}">
                    Latest Dubbed: Epsiode {{ $syn_show->latest_dub->episode_num }}; Uploaded on {{ $syn_show->latest_dub->uploadtime->format('M j, Y (l)') }}
                  </a>
                @else
                  Latest Dubbed: No episodes available
                @endif
              </div>
            @endif
          </div>
        </div>
      @endif
    </div>

  </div>
</div>

<!--
  $syn_mal
  $syn_show
  $syn_unique
  ($syn_video)
-->
