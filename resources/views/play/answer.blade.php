<x-Play-layout>

    <section class="text-gray-600 body-font">
        <div class="container px-5 py-24 mx-auto">
            <div class="flex flex-col text-center w-full mb-20">
                <h1 class="sm:text-4xl text-3xl font-medium title-font mb-2 text-gray-900">{{
                    $isCorrectAnswer == 1 ? '正解です' : "不正解です"
                    }}
                </h1>
                <p class="lg:w-2/3 mx-auto leading-relaxed text-base">問題：{{ $quiz['question'] }}</p>
                <p class="lg:w-2/3 mx-auto leading-relaxed text-base">解説：{{ $quiz['explanation'] }}</p>
            </div>

            {{-- <div>{{ }}</div> --}}
            {{-- どのクイズの解答か認識するためにクイズIDを送る --}}
            <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                <table class="table-auto w-full text-left whitespace-no-wrap">
                    <thead>
                        <tr>
                            <th
                                class="w-10  whitespace-nowrap px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">
                                番号
                            </th>
                            <th
                                class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                選択肢
                            </th>
                            <th
                                class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                正解・不正解
                            </th>
                            <th
                                class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                あなたの解答
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- 選んだ選択肢 --}}
                        @foreach ($quizOptions as $quizOption)
                        <tr>
                            <td class="px-4 py-3">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3">{{ $quizOption['content'] }}</td>
                            <td class="px-4 py-3">{{$quizOption['is_correct'] !== 0 ? '⭕️' : '❌'}}</td>
                            <td class="px-4 py-3">
                                {{ in_array($quizOption['id'], $selectedOptions) ? '⭕️' : '❌'}}
                            </td>

                            {{-- <td class="w-10 text-center">
                                <input name="optionId[]" value="{{ $option['id'] }} "type="checkbox">
                            </td> --}}
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="flex pl-4 mt-4 lg:w-2/3 w-full mx-auto">
                <button
                    class="flex ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">次の問題へ
                </button>
            </div>
        </div>
    </section>
</x-Play-layout>
