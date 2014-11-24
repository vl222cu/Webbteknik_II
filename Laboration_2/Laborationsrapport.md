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

### Säkerhetshål

> Applikationen är inte skyddad mot sql-injections

### Hur säkerhetshålet kan utnyttjas

> Genom att skjuta in skadlig kod som exekveras mot databasen

### Vad för skada säkerhetshålet kan göra

> En lyckad sql-injectionsattack tillåter angriparen att komma över känslig information i databasen såsom användaruppgifter, att manipulera databasens innehåll, att förstöra databasens innehåll eller att ta över databasservern helt och hållet

### Åtgärd av säkerhetshål

> Genom att parametrisera SQL-satserna 

* * *

### Säkerhetshål

> Validering mot ogiltiga tecken saknas i namnfält och textboxfält såsom HTML-taggar

### Hur säkerhetshålet kan utnyttjas

> Genom att skicka in skadlig kod via scripttagg, a-tagg etc

### Vad för skada säkerhetshålet kan göra

> Det kan orsaka oönskade effekter i webbläsaren eller användas för att stjäla information från webbläsaren genom cross site scripting

### Åtgärd av säkerhetshål

> Genom att sanitera indata och ta bort ogiltiga tecken

* * *

### Säkerhetshål

> Saknar skydd mot sessionsstölder

### Hur säkerhetshålet kan utnyttjas

> Genom att använda den stulna sessionskakan för att logga in i en annan typ av webbläsare

### Vad för skada säkerhetshålet kan göra

> Identitetsstölder, bedrägerier

### Åtgärd av säkerhetshål

> Genom att kontrollera användarens webbläsare och/eller IP-adress

* * *



