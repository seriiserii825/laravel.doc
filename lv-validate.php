// command
php artisan make:request DeskStoreRequest

Controller was created in Http/Requests

Store
<?php 
    public function rules()
    {
        return [
            'employee_id' =>  [
                'required',
                Rule::unique('salaries')
                    ->where('employee_id', $this->employee_id)
                    ->where('month', $this->month)
            ],
            'amount' => 'required',
            'date' => 'required',
            'month' => 'required',
            'year' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'employee_id.unique' => 'Combination of Employee id & month is not unique',
        ];
    }
 ?>
Update
 <?php 
    public function rules()
    {
        return [
            'employee_id' =>  [
                'required',
                Rule::unique('salaries')
                    ->ignore($this->salary)
                    ->where('employee_id', $this->employee_id)
                    ->where('month', $this->month)
            ],
            'amount' => 'required',
            'date' => 'nullable',
            'month' => 'nullable',
            'year' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'employee_id.unique' => 'Combination of Employee id & month is not unique',
        ];
    }
 ?>
