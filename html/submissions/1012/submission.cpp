#include<cstdio>
#include<cstring>
int n, a[11], b[11], p[500], f[11], g[500];
long cnt=0;

void print()
{
    //for (int i=0; i<n; ++i) printf("%d ", b[i]);
    //printf("\n");
    ++cnt;
}

void construct(int i)
{
    for (int j=0; j<n; ++j)
        if (!f[j])
        {
            int check=1;
            for (int k=0; k<i-1; ++k)
                if (g[a[j]+b[k]]&&p[a[j]+b[k]]>k) check=0;
            if (!check) break;
            f[j]=1;
            g[2*a[j]]=1;
            p[2*a[j]]=j;
            b[i]=a[j];
            if (i==n-1) print();
            else construct(i+1);
            f[j]=0;
            g[2*a[j]]=0;
            p[2*a[j]]=0;
            b[i]=0;
        }
}

int main()
{
    freopen("SORT.inp", "r", stdin);
    freopen("SORT.out", "w", stdout);
    scanf("%d", &n);
    for (int i=0; i<n; ++i) scanf("%d", a+i);
    memset(b, 0, sizeof(b));
    memset(f, 0, sizeof(f));
    memset(g, 0, sizeof(g));
    memset(p, 0, sizeof(p));
    construct(0);
    printf("%ld", cnt);
    fclose(stdin);
    fclose(stdout);
    return 0;
}
