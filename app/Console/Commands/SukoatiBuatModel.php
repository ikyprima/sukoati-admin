<?php

namespace App\Console\Commands;

use Illuminate\Support\Pluralizer;
use Illuminate\Console\GeneratorCommand;
class SukoatiBuatModel extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sukoati:buat-model {name} {--tablename=} {--primarykey=} {--fillable=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'buat model baru';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $path = $this->getSourceFilePath();
        $contents = $this->getSourceFile();

        if (!$this->files->exists($path)) {
            $this->files->put($path, $contents);
            $this->info("File : {$path} created");
        } else {
            $this->info("File : {$path} already exits");
        }

    }

    /**
    **
    * Map the stub variables present in stub to its value
    *
    * @return array
    *
    */
    public function getStubVariables()
    {
        $name = $this->argument('name');
        $tableName = $this->input->getOption('tablename');

        if($tableName){
            $table = "protected \$table = '{$this->getNameTable($tableName)}';";
        }else{
            $table  = null;
        }
        $primaryKeyValue = $this->input->getOption('primarykey');
        if($primaryKeyValue){
            if ($primaryKeyValue != 'id') {
                $primaryKey = "protected \$primaryKey = '{$primaryKeyValue}';";
            }else{
                $primaryKey = null;
            }
        }else{
            $primaryKey = null;
        }
        $fillAble = $this->input->getOption('fillable');
        if($fillAble){
            $fillAble = "protected \$fillable = [{$this->getFillableAttributes($fillAble)}];";
        }else{
            $fillAble = null;
        }
        
        return [
            'NAMESPACE'         => 'App\\Models\\Sukoati',
            'CLASS_NAME'        => $this->getSingularClassName($name),
            'TABLE'             => $table,
            'FILLABLE'          => $fillAble,
            'PRIMARYKEY'        => $primaryKey
        ];
    }

    /**
     * Return the stub file path
     * @return string
     *
     */
    protected function getStub()
    {
        return  base_path() . '/stubs/sukoati-stubs/model.stub';
    }

    /**
     * Get the stub path and the stub variables
     *
     * @return bool|mixed|string
     *
     */
    public function getSourceFile()
    {
        return $this->getStubContents($this->getStub(), $this->getStubVariables());
    }

    /**
     * Replace the stub variables(key) with the desire value
     *
     * @param $stub
     * @param array $stubVariables
     * @return bool|mixed|string
     */
    public function getStubContents($stub , $stubVariables = [])
    {
        $contents = file_get_contents($stub);

        foreach ($stubVariables as $search => $replace)
        {
            $contents = str_replace('$'.$search.'$' , $replace, $contents);
        }

        return $contents;

    }

    /**
     * Get the full path of generate class
     *
     * @return string
     */
    public function getSourceFilePath()
    {
        $modelsDirectory = app_path('Models/Sukoati');

        // Mengecek apakah direktori sudah ada atau belum
        if (!file_exists($modelsDirectory)) {
            // Membuat direktori jika belum ada
            mkdir($modelsDirectory, 0755, true);
        }

        return  app_path("Models/Sukoati/{$this->getSingularClassName($this->argument('name'))}.php");
    }

    /**
     * Return the Singular Capitalize Name
     * @param $name
     * @return string
     */

    public function getSingularClassName($name)
    {
        return ucwords(Pluralizer::singular($name));
    }

    /**
     * Get the fillable attributes as a string.
     *
     * @return string
     */
    protected function getFillableAttributes($fillable=null)
    {
    
        // $fillable = $this->ask('Enter fillable attributes (comma-separated)');
    
        $fillableArray = array_map('trim', explode(',', $fillable));
        $fillableString = implode(', ', array_map(function ($attribute) {
            return "'$attribute'";
        }, $fillableArray));

        return $fillableString;
    }

    /**
     * Get the name table attributes as a string.
     *
     * @return string
     */
    protected function getNameTable($table = null){
        return $table;
    }
}
