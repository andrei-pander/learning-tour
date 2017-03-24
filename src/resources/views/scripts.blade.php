<script>
    $(document).ready(function () {
        var language = {
            nextBtn: "Далее",
            prevBtn: "Назад",
            doneBtn: "Готово",
            skipBtn: "Пропустить",
            closeTooltip: "Закрыть"
        };
        hopscotch.configure({i18n: language});
        var config = {
            deferred: {{ isset($deferred) ? $deferred : true }},
            csrf: "{{ csrf_token() }}",
            fetchToursPath: '{{ config('learningtour.routes.fetch_path') }}',
            updateStepPath: '{{ config('learningtour.routes.update_path') }}',
            completeTourPath: '{{ config('learningtour.routes.complete_path') }}',
            tours: {!! json_encode($learningtours) !!}
        };
        learningTour.init(config);
    });
</script>
