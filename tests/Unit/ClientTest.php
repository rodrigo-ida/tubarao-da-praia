<?php

namespace Tests\Unit;

use App\Client;
use App\Contracts\Services\ClientService as ClientServiceContract;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Mockery as m;
use Tests\TestCase;

class ClientTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Verifies if resetLoginToken changes current login token
     */
    public function test_reset_login_token_success()
    {
        /* @var $service ClientServiceContract|\Mockery\MockInterface */
        $service = m::mock(ClientServiceContract::class)->makePartial();
        $service->shouldReceive('generateUniqueLoginToken')->andReturn('anewtoken');

        $client = new Client();
        $client->login_token = "somedummytoken";
        $client->resetLoginToken($service);

        $expected = "somedummytoken";
        $actual = $client->login_token;

        $this->assertNotEquals($expected, $actual);
    }

    /**
     * Check that we have validation errors after validation failed
     */
    public function test_failed_validation_populates_errors ()
    {
        $client = new Client();
        $this->assertFalse($client->validate());
        $this->assertFalse($client->getErrors()->isEmpty());
    }

    /**
     * If we have a valid Client, validation must pass
     */
    public function test_successful_validation()
    {
        $client = factory(Client::class)->make();
        $this->assertTrue($client->validate());
    }

    /**
     * Ensure that multiple consecutive validations calls don't affect next result
     */
    public function test_can_call_validate_consecutive_times()
    {
        // valid client
        $client = factory(Client::class)->make();
        $isValid = $client->validate();

        $client->email = '';
        $isInvalid = !$client->validate();

        $client->email = 'test@test.com';
        $isValidAgain = $client->validate();

        $this->assertTrue($isValid);
        $this->assertTrue($isInvalid);
        $this->assertTrue($isValidAgain);
    }

    /**
     * Check that we don't have validation errors after successful validation
     */
    public function test_successful_validation_has_empty_errors ()
    {
        $client = factory(Client::class)->make();
        $this->assertTrue($client->validate());
        $this->assertTrue($client->getErrors()->isEmpty());
    }

    /**
     * Tests validation with possible invalid nome parameter
     * @dataProvider \Tests\ValidationTestHelper::basicRequiredInputTest
     * @dataProvider invalidNameMinMax
     */
    public function test_validate_with_invalid_nome($invalidValue)
    {
        $client = new Client();
        $client->nome = $invalidValue;
        $this->assertTrue($this->hasValidationErrorFor($client, 'nome'));
    }

    /**
     * Tests validation with possible invalid whatsapp parameter
     * @dataProvider \Tests\ValidationTestHelper::basicRequiredInputTest
     */
    public function test_validate_with_invalid_whatsapp($invalidValue)
    {
        $client = new Client();
        $client->whatsapp = $invalidValue;
        $this->assertTrue($this->hasValidationErrorFor($client, 'whatsapp'));
    }

    /**
     * Tests validation with possible invalid email parameter
     * @dataProvider \Tests\ValidationTestHelper::basicRequiredInputTest
     * @dataProvider \Tests\ValidationTestHelper::basicEmailInputTest
     */
    public function test_validate_with_invalid_email($invalidValue)
    {
        $client = new Client();
        $client->email = $invalidValue;
        $this->assertTrue($this->hasValidationErrorFor($client, 'email'));
    }

    /**
     * Tests validation with possible invalid cep parameter
     * @dataProvider \Tests\ValidationTestHelper::basicRequiredInputTest
     */
    public function test_validate_with_invalid_cep($invalidValue)
    {
        $client = new Client();
        $client->cep = $invalidValue;
        $this->assertTrue($this->hasValidationErrorFor($client, 'cep'));
    }

    /**
     * Tests validation with possible invalid estado parameter
     * @dataProvider \Tests\ValidationTestHelper::basicRequiredInputTest
     */
    public function test_validate_with_invalid_estado($invalidValue)
    {
        $client = new Client();
        $client->estado = $invalidValue;
        $this->assertTrue($this->hasValidationErrorFor($client, 'estado'));
    }

    /**
     * Tests validation with possible invalid cidade parameter
     * @dataProvider \Tests\ValidationTestHelper::basicRequiredInputTest
     */
    public function test_validate_with_invalid_cidade($invalidValue)
    {
        $client = new Client(['cidade' => $invalidValue]);
        $this->assertTrue($this->hasValidationErrorFor($client, 'cidade'));
    }

    /**
     * Tests validation with possible invalid bairro parameter
     * @dataProvider \Tests\ValidationTestHelper::basicRequiredInputTest
     */
    public function test_validate_with_invalid_bairro($invalidValue)
    {
        $client = new Client(['bairro' => $invalidValue]);
        $this->assertTrue($this->hasValidationErrorFor($client, 'bairro'));
    }

    /**
     * Tests validation with possible invalid logradouro parameter
     * @dataProvider \Tests\ValidationTestHelper::basicRequiredInputTest
     */
    public function test_validate_with_invalid_logradouro($invalidValue)
    {
        $client = new Client(['logradouro' => $invalidValue]);
        $this->assertTrue($this->hasValidationErrorFor($client, 'logradouro'));
    }

    /**
     * Tests validation with possible invalid numero parameter
     * @dataProvider \Tests\ValidationTestHelper::basicRequiredInputTest
     */
    public function test_validate_with_invalid_numero($invalidValue)
    {
        $client = new Client(['numero' => $invalidValue]);
        $this->assertTrue($this->hasValidationErrorFor($client, 'numero'));
    }

    /**
     * Tests validation with possible invalid complemento parameter
     * @dataProvider invalidComplemento
     */
    public function test_validate_with_invalid_complemento($invalidValue)
    {
        $client = new Client(['complemento' => $invalidValue]);
        $this->assertTrue($this->hasValidationErrorFor($client, 'complemento'));
    }

    /**
     * Tests validation with possible invalid data_nasc parameter
     * @dataProvider \Tests\ValidationTestHelper::basicRequiredInputTest
     * @dataProvider \Tests\ValidationTestHelper::basicDateStringInputTest
     */
    public function test_validate_with_invalid_data_nasc($invalidValue)
    {
        $client = new Client(['data_nasc' => $invalidValue]);
        $this->assertTrue($this->hasValidationErrorFor($client, 'data_nasc'));
    }

    /**
     * Tests validation with possible invalid sexo parameter
     * @dataProvider \Tests\ValidationTestHelper::basicRequiredInputTest
     * @dataProvider invalidSexo
     */
    public function test_validate_with_invalid_sexo($invalidValue)
    {
        $client = new Client(['sexo' => $invalidValue]);
        $this->assertTrue($this->hasValidationErrorFor($client, 'sexo'));
    }

    /**
     * Tests validation with possible valid sexo parameter
     * @dataProvider validSexo
     */
    public function test_validate_with_valid_sexo($validValue)
    {
        $client = new Client(['sexo' => $validValue]);
        $this->assertTrue($this->hasNoValidationErrorFor($client, 'sexo'));
    }

    /**
     * Test validation with duplicated email
     */
    public function test_validation_error_with_duplicated_email()
    {
        // first client without errors and save for future database check
        $client = factory(Client::class)->make([
            'email' => 'test@test.com'
        ]);
        $this->assertTrue($this->hasNoValidationErrorFor($client, 'email', true, 'Unique'));
        $client->save();

        // second client should fail on validate for create new
        $client2 = factory(Client::class)->make([
            'email' => 'test@test.com'
        ]);
        $this->assertTrue($this->hasValidationErrorFor($client2, 'email', true, 'Unique'));

        // second client with new email should pass and save for future check
        $client2->email = 'test2@test.com';
        $this->assertTrue($this->hasNoValidationErrorFor($client2, 'email', true, 'Unique'));
        $client2->save();

        // validate for update on first client with same original email should pass
        $this->assertTrue($this->hasNoValidationErrorFor($client, 'email', false, 'Unique'));

        // validate for update on first client with second client email should fail
        $client->email = 'test2@test.com';
        $this->assertTrue($this->hasValidationErrorFor($client, 'email', false, 'Unique'));
    }

    /**
     * Verifies if $client validation has error for specific attribute and, if supllied, constrained to $rule
     * @param Client $client
     * @param $attribute
     * @param bool $new
     * @param null $rule
     * @return bool
     */
    private function hasValidationErrorFor(Client $client, $attribute, $new = true, $rule = null)
    {
        // first validate and check that its not validated,
        // otherwise we don't have validation errors and return false
        $validated = $client->validate($new);
        if ($validated)
            return false;

        // check for errors
        $failed = $client->getValidator()->failed();
        $hasErrorForAttribute = array_key_exists($attribute, $failed);

        // if is an any rule check return true for any errors on attribute or false
        // or check errors for specific rule
        if ($rule == null) {
            return $hasErrorForAttribute;
        } else {
            return isset($failed[$attribute]) && array_key_exists($rule, $failed[$attribute]);
        }
    }

    /**
     * Verifies if $client validation don't have errors for specific attribute and, if supllied, constrained to $rule
     * @param Client $client
     * @param $attribute
     * @param bool $new
     * @param null $rule
     * @return bool
     */
    private function hasNoValidationErrorFor(Client $client, $attribute, $new = true, $rule = null)
    {
        // first validate to generate possible errors
        $client->validate($new);

        // check for errors
        $failed = $client->getValidator()->failed();
        $hasNoErrorForAttribute = !array_key_exists($attribute, $failed);

        // if is an any rule check, return true if don't have any errors for attribute
        // or check that don't have no errors for a specific rule
        if ($rule == null) {
            return $hasNoErrorForAttribute;
        } else {
            return !isset($failed[$attribute]) || !array_key_exists($rule, $failed[$attribute]);
        }
    }

    /**
     * Set of invalid Name values
     * @return array
     */
    public function invalidNameMinMax()
    {
        return [
            ['ab'],
            [str_random(192)]
        ];
    }

    /**
     * Set of invalid Comlemento values
     * @return array
     */
    public function invalidComplemento()
    {
        return [
            [str_random(192)]
        ];
    }

    /**
     * Set of invalid Sexo values
     * @return array
     */
    public function invalidSexo()
    {
        return [
            ['someInvalidSexo']
        ];
    }

    /**
     * Set of valid Sexo values
     * @return array
     */
    public function validSexo()
    {
        return [
            ['Masculino'],
            ['Feminino']
        ];
    }

}