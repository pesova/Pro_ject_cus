<li>
    <a href="javascript: void(0);">
        <i class="uil uil-shop"></i>
        <span class='second'> Business </span>
        <span class="menu-arrow"></span>
    </a>

    <ul class="nav-second-level" aria-expanded="false">
        <li>
            <a href="{{ route('store.index') }}">Manage Businesses</a>
        </li>
        {{---<li>
            <a href="{{ route('assistants.index') }}">Manage Store Assistant</a>
</li>
<li>
    <a href="{{ route('debtor.index') }}">Manage Debts</a>
</li>---}}
    </ul>
</li>


<li>
    <a href="javascript: void(0);">
        <i data-feather="credit-card"></i>
        <span class='fourth'> Transactions </span>
        <span class="menu-arrow"></span>
    </a>

    <ul class="nav-second-level" aria-expanded="false">
        <li>
            <a href="{{ route('debtor.index') }}">Debts</a>
        </li>
        <li>
            <a href="{{ route('transaction.index') }}">Payments</a>
        </li>
    </ul>
</li>


<li>
    <a href="{{ route('customer.index') }}">
        <i class='uil uil-chat-bubble-user'></i>
        <span class='third'> Customers </span>
    </a>
</li>


<li>
    <a href="{{ route('broadcast.index') }}">
        <i data-feather="message-square"></i>
        <span class='fifth'> Broadcast Message </span>
    </a>
</li>

<li>
    <a href="{{ route('complaint.index') }}">
        <i data-feather="book"></i>
        <span class='sixth'>Support</span>
    </a>
</li>

<li>
    <a href="{{ route('activities.index') }}">
        <i data-feather="activity"></i>
        <span> Activity Log </span>
    </a>
</li>
<li>
    <a href="{{ route('PaymentLog.index') }}">
        <i data-feather="credit-card"></i>
        <span> Payments Log </span>
    </a>
</li>


<li>
    <a href="javascript: void(0);">
        <i class="uil  uil-cog"></i>
        <span class='seventh'> Settings </span>
        <span class="menu-arrow"></span>
    </a>

    <ul class="nav-second-level" aria-expanded="false">

        <li>
            <a href="{{ route('users.index') }}">
                <span> Manage Users </span>
            </a>
        </li>

        <li>
            <a href="{{ route('assistants.index') }}">Manage Assistants</a>
        </li>
        {{-- <li><a href="{{ route('setting') }}">
                <span class='seventh'> Edit Profile </span>
            </a>
        </li> --}}
    </ul>
</li>
