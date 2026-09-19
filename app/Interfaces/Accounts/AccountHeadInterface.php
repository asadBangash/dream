<?php

namespace App\Interfaces\Accounts;

interface AccountHeadInterface
{

    public function getAll();

    public function getIncomeHeads();
    public function getExpenseHeads();

    public function store($request);

    public function show($id);

    public function update($request, $id);

    public function destroy($id);
}
