@extends('account.layout')

@section('account.content')
  <div class="space-y-4">
    <div>You are connected with:</div>
    @foreach ($connectedSocialAccounts as $index => $account)
      <div
        class="flex flex-row justify-between px-6 py-4 @if ($index % 2 == 0) bg-orange-100 @else bg-orange-50 @endif">
        <div class="flex items-center space-x-2">
          <img src="{{ asset("storage/oath-providers/$account->name.svg") }}" alt="Google Logo" class='h-5'>
          <div class="text-black text-lg font-bold">
            {{ $account->friendly_name }}
          </div>
        </div>
        {{-- <div>
          <form action="{{ route('account.social_accounts.destroy', $account) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="link text-sm"
              title="Unlink association with {{ $account->friendly_name }}">unlink</button>
          </form>
        </div> --}}
      </div>
    @endforeach
  </div>
@endsection
