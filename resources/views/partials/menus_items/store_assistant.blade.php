<li>
    <a href="javascript: void(0);">
        <i data-feather="credit-card"></i>
        <span> Transactions </span>
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
        <span class="fourth"> Customers </span>
    </a>
</li>

<li>
    <a href="{{ route('broadcast.index') }}">
        <i data-feather="message-square"></i>
        <span> Broadcast Message </span>
    </a>
</li>


<li>
    <a href="{{ route('complaint.index') }}">
        <i data-feather="book"></i>
        <span> Support</span>
    </a>
</li>

<li>
    <a href="{{ route('setting') }}">
        <i class="uil  uil-cog"></i>
        <span class ='seventh'> Edit Profile </span>
    </a>
</li>