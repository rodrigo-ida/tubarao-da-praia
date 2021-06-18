{{ csrf_field() }}
<div class="form-group">
    <table class="table table-hover table-dark">
        <thead>
            <tr>
                <th>Hora abertura</th>
                <th>Hora fechamento</th>
            </tr>
        </thead>
        <tbody>
        <tr>
            <td>

                {{ Form::select('config_time', $horas, date_format(new DateTime($config->config_time), 'H:i')) }}
                <!-- <select name="config_time" id="config_time_segunda">
                    

                </select>             -->
            
            </td>
            <td>
            
                {{ Form::select('config_time_end', $horas, date_format(new DateTime($config->config_time_end), 'H:i')) }}
                <!-- <select name="config_time_end" id="config_time_segunda">
                    
                   

                </select>             -->
            
            </td>
        </tr>
    </table>
</div>
<input type="hidden" name="config_loja_id" value="{{ $config->getLoja()->First()->id }}">
<div class="checkbox">
    Status:
    <label>
        {{ Form::radio('config_status', '1') }}
        Ativado
    </label>
    <label>
        {{ Form::radio('config_status', '0')}}
        Desativado
    </label>
</div>