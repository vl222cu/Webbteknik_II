Laborationsrapport
==================

### Säkerhetshål

> Hashningen sker på användarnamnet och inte lösenordet. Detta gör att lösenordet används i klartext i databasen och kan återges.

### Hur säkerhetshålet kan utnyttjas

> Om databasen hamnar i orätta händer kommer även förövraren åt alla användaruppgifter utan större problem och kan då komma över användarnas konton.

### Vad för skada säkerhetshålet kan göra

> Identitetsstölder, bedrägerier

### Åtgärd av säkerhetshål

> Hashar lösenordet med slumpad salt för att få unik hash

* * *
