@extends('layout')

@section('pageHeading')
    <h1>
        <a href="/">/</a> Series upload notifications ({{{ $notifyCount }}})
    </h1>
@stop


@section('main')
    @parent
    
    <div class="container">
        @if(count($watched) > 0 || count($notifications) > 0)
            <h2>New uploads</h2>
            @if(count($notifications) === 0)
                <p>
                    You have no new upload notifications!
                </p>
            @else
                <form method="post" action="{{{ URL::route('notificationDismiss') }}}">
                    {{ Form::token() }}
                    <table>
                        <thead>
                            <tr>
                                <th>Path</th>
                                <th>Uploaded</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($notifications as $notify)
                                <?php $path = $notify->pathRecord->getPath(); ?>
                                <tr @if($notify->dismissed)class="dismissed"@endif>
                                    <td><a href="{{{ $notify->getUrl() }}}">{{{ $path->getRelative() }}}</a></td>
                                    <td>{{{ $path->getDisplayTime() }}}</td>
                                    <td>
                                        @if(!$notify->dismissed)
                                            <button name="notification" value="{{{ $notify->id }}}" class="button-text">Dismiss</button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        @if($notifyCount > 0)
                            <tfoot>
                                <tr>
                                    <td colspan="2"></td>
                                    <td>
                                        <button id="dismiss-notify-all" name="all" value="true" class="button-text">Dismiss all</button>
                                    </td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </form>

                {{ $notifications->links() }}
            @endif
        @endif

        <h2>Watched series</h2>
        @if(count($watched) === 0)
            <p>
                You have no series watched!<br/>
                <br/>
                Visit a directory that has a series assigned and click the "Watch series" button.
            </p>
        @else
            <form method="post" action="/user/notifications/watch">
                {{ Form::token() }}
                
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($watched as $series)
                            <tr @if(count($series->pathRecords) !== 1)class="has-paths"@endif>
                                <td>
                                    @if(count($series->pathRecords) === 1)
                                        <?php $path = $series->pathRecords->first()->getPath(); ?>
                                        <a href="{{{ $path->getUrl() }}}">{{{ $series->name }}}</a>
                                    @else
                                        <a href="#" class="series-paths-trigger">{{{ $series->name }}}</a>
                                    @endif
                                </td>
                                <td>
                                    <button id="unwatch" name="series" value="{{{ $series->id }}}" class="button-text">Unwatch</button>
                                </td>
                            </tr>
                            @if(count($series->pathRecords) !== 1)
                                <tr class="series-paths-expand">
                                    <td colspan="2">
                                        <div class="paths">
                                            <div class="inner">
                                                @foreach($series->pathRecords as $record)
                                                    <?php $path = $record->getPath(); ?>
                                                    <a href="{{{ $path->getUrl() }}}">{{{ $path->getRelativeTop(2) }}}</a><br/>
                                                @endforeach
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </form>
        @endif
    </div>
@stop